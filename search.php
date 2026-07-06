<?php
require "config.php";

header("Content-Type: text/html; charset=UTF-8");

if(isset($_GET['q']) && !empty($_GET['q'])) {

    $q = $_GET['q'];

    $stmt = $conn->prepare("
        SELECT id, titre 
        FROM articles 
        WHERE titre LIKE ? OR contenu LIKE ? 
        LIMIT 5
    ");

    $search = "%$q%";
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $safeId = (int)$row['id'];
            $safeTitre = htmlspecialchars($row['titre'], ENT_QUOTES, 'UTF-8');
            echo "<div class='suggestion-item'
                    onclick=\"window.location.href='article.php?id=".$safeId."'\">
                    ".$safeTitre."
                  </div>";
        }
    } else {
        echo "<div class='suggestion-item'>Aucun résultat</div>";
    }

} else {
    echo "";
}
?>