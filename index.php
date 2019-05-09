<?php


  class Pagamento
  {
    public $id;
    public $status;
    public $price;

    function __construct($id, $status, $price)
    {
      $this -> id = $id;
      $this -> status = $status;
      $this -> price = $price;
    }

    public function printme()
    {
      echo(
            $this -> id . ": " .
            $this -> status . " " .
            $this -> price . "€ <br>"
          );
    }
  }

  $server = "localhost";
  $name = "root";
  $password = "******";
  $database = "Hotel";

  $conn = new mysqli($server, $name, $password, $database);
  // var_dump($conn); die();

  if ($conn -> connect_errno) {

    echo "Errore di connessione " . $conn -> connect_error;
    return;
  }

  $sql = "
          SELECT id, status, price
          FROM pagamenti
          ORDER BY price DESC
          ";

  $result = $conn ->query($sql);
  // var_dump($result); die();

  if ($result -> num_rows >0) {

    $rejecteds = [];
    $accepteds = [];
    $pendings = [];

    while ($row = $result -> fetch_assoc()) {

      if ($row["status"] == "rejected") {
        $rejecteds[] = new Pagamento(
          $row["id"],
          $row["status"],
          $row["price"]
        );
      } elseif ($row["status"] == "accepted") {
        $accepteds[] = new Pagamento(
          $row["id"],
          $row["status"],
          $row["price"]
        );
      } else {
        $pendings[] = new Pagamento(
          $row["id"],
          $row["status"],
          $row["price"]
        );
      }
    }
    // var_dump($rejecteds, $accepteds, $pendings); die ();
  }
  else {
    echo "0 risultati";
  }
  $conn -> close();

  foreach ($rejecteds as $rejected) {

    // echo(
    //       $rejected -> id . ": " .
    //       $rejected -> status . " " .
    //       $rejected -> price . "<br>"
    //     );

      // OPPURE LE STAMPO DIRETTAMENTE CON UNA FUNZIONE INTERNA ALLA CLASSE

    $rejected -> printme();
  }

  echo "<hr>";

  foreach ($accepteds as $accepted) {
    $accepted -> printme();
  }

  echo "<hr>";

  foreach ($pendings as $pending) {
    $pending -> printme();
  }


 ?>
