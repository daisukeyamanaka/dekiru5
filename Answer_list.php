<?php
include("functions.php");

$id = $_GET['id'];

$pdo = connect_to_db();

$sql = 'SELECT * FROM customer join answer on customer.id = answer.questionID WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    $i =0;
    foreach ($result as $record) {
        $i=$i+1;
        $output .= "
          <tr>
            <td>{$i}:{$record["ans"]}</td>
            <td>
              <a href='chat.php?id={$record["id"]}'>☆macchi☆</a>
            </td>
          </tr>
        ";
      }
}

?>
<form action="completion.php" method="POST">
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="sample.css" />
    <div>
        悩み事:
        <textarea type="text" name="todo" id="" cols="30" rows="10" maxlength="128" onclick="this.value=''; return false"><?= $record['todo'] ?> </textarea>
    </div>
    <fieldset>
        <div>
        <?= $output ?>
        </div>
    </fieldset>
</form>