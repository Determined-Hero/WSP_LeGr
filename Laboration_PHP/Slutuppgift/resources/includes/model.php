<?php
require 'resources/includes/db_conn.php'; // Kommentar här

if ($pdo) {

    // Tabellen "Posts" [som innehåller: ett inläggs id (P.ID), url address (P.Slug), titel (P.Headline), text (P.Text), datum och tid när inlägget var skapad eller ändrad (P.Creation_time)] ansluter sig(JOIN) till tabellen "Users"[som innehåller: en användares förnamn (U.Firstname) och efternamn (U.Lastname) som ansluter (CONCAT) tillsammans till kolumnen Namn (Name)]. En avändares id (U.ID) blir lika med id från en inläggs avändare (P.User_ID) som blir sorterade av datum och tid när ett inlägg var skapad eller ändrad (P.Creation_time).
    $sql = 'SELECT P.ID, P.Slug, P.Headline, CONCAT(U.FName, " ", U.LName) AS Name, P.Creation_time, P.Text FROM posts AS P JOIN users AS U ON U.ID = P.User_ID ORDER BY P.Creation_time DESC';

    // En if statement med en search button
    if (isset($_POST['search'])) {
        // $_POST samlar in data från formen 'what'
        $data = $_POST['what'];

        /**********************************************************/
        /*********************** C-UPPGIFT 1 **********************/
        /*** Variabeln $data kan innehålla, som den är utformad, **/
        /********* information som kan skada vår databas. *********/
        /*** För betyget C så kräver jag att ni säkerställer att **/
        /***** $data inte innehåller någon form av skadlig kod ****/
        /**********************************************************/

        /**********************************************************/
        /*********************** C-UPPGIFT 2 **********************/
        /* I filen all-posts.php så skrivs det ut en kortare text */
        /* följt av en länk till berört inlägg. Vore det inte mer */
        /* passande att det istället skrivs ut ord från inlägget? */
        /* För betyget C så kräver jag att ni tar fram en lösning */
        /**** där 10 ord från inlägget skrivs ut före läs mer. ****/
        /************ Tänk implode och/eller explode! *************/
        /**********************************************************/

        /**********************************************************/
        /************************ A-UPPGIFT ***********************/
        /** Som det är just nu så tar vi bara in en variabel som **/
        /******* vi använder när vi söker igenom databasen. *******/
        /* Tittar man på sidor som exempelvis google och facebook */
        /**** så kan din sökning oftast innehålla flera sökord ****/
        /* För betyget A så kräver jag att ni tar fram en lösning */
        /** som gör det möjligt för användaren att kunna söka på **/
        /** flera separerade ord. Att man exempelvis kan söka på **/
        /***** texter som innehåller både "Lorum" och "Ipsum." ****/
        /**********************************************************/

        // En if statement med $data [som är alltid inställd, men dess innehåll kan vara tomt] och !empty() [som kontrollerar om värdet är inställt]. En SELECT statement som väljer ett inläggs id (P.ID), url address (P.Slug), titel (P.Headline) som är anslutna tillsammans med en användares förnamn (U.Firstname) och efternamn (U.Lastname) som är ihop som kolumnen Namn (Name). Denna SELECT statement väljer också ett inläggs text (P.Text), datum och tid när inlägget var skapad eller ändrad (P.Creation_time) ansluter sig (JOIN) till tabellen "Users" och kolumnen U.ID blir lika med P.User_ID där ett inläggs text (p.Text) och $data har noll, en eller flera tecken som blir sorterade av datum och tid när ett inlägg var skapad eller ändrad (P.Creation_time).
        if (!empty($data)) {
            $sql = 'SELECT p.ID, p.Slug, p.Headline, CONCAT(u.Firstname, " ", u.Lastname) AS Name, p.Creation_time, p.Text FROM Posts AS p JOIN Users AS u ON U.ID = P.User_ID WHERE p.Text LIKE "%'.$data.'%" ORDER BY P.Creation_time DESC';
        }
    }

    // En model array med foreach statement som utför eller blockerar ett statement.
    $model = array();
    foreach($pdo->query($sql) as $row) {
        // En model array som lagrar data som togs ifrån flera identifierade kolummner som finns på en databas. $row lagrar arrays ('Slug', 'Headline', 'Name', 'Creation_time', 'Text') på rad. En else statement som anger ett block av kod som ska utföras om samma villkor är felaktiga och print_r som visar information om en variabel på ett sätt som kan läsas av människor. $pdo->errorInfo() lämnar en rad felinformation om den senaste operationen som har utförts av detta databas.
        $model += array(
            $row['ID'] => array(
                'slug' => $row['Slug'],
                'title' => $row['Headline'],
                'author' => $row['Name'],
                'date' => $row['Creation_time'],
                'text' => $row['Text']
            )
        );
    }
}
else {
    print_r($pdo->errorInfo());
}
?>
