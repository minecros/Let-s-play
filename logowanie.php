<?php

session_start();
	
	

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if($polaczenie->connect_errno!=0){
    
    echo "Error ".$polaczenie->connect_errno;
    
}else{
    
    @$login = $_POST['login'];
    @$haslo = $_POST['passwd'];
    @$passwd_hash = password_hash($haslo, PASSWORD_DEFAULT);
    
   $sql = "SELECT login FROM konta WHERE login='".$login."' AND haslo='".$passwd_hash."'";
    
    if($rezultat = @$polaczenie->query($sql) == true){
        
        
        @$ilu_userow = $rezultat->num_rows;
        
        
        if($ilu_userow == 1){
            
            
            echo 'zalogowany';
            
            
            
            
        }else{
                 
            echo $ilu_userow;
            
             }
        
       
    }
    
    $polaczenie->close();
    
    
    
                
            
             
    
}
    

    



?>
<!DOCTYPE HTML>
<html lang="pl">

<head>

    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <script>

        function Strona(){
                
               alert "Siemaadasd";
            }
        
        
        </script>




    <header>

        <h1 class="logo">LETS PLAY</h1>

        <nav>

            <ul class="menu">
                 <li><a href="index.php">Strona główna</a></li>
                    <li><a href="rejestracja.php">Pierwszy raz tutaj?</a></li>
                    <li><a href="dlaczego.php">Dlaczego tak?</a></li>
                    <li><a href="autor.php">O autorze</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="logowanie.php">Logowanie</a></li>
            </ul>


        </nav>

    </header>






    <article id="glowny">

        <div id="strona">
            
            
           
                
                <form name="logowanie" method="post" action="logowanie.php" id="logowanie">

                <div class="logowanie">Login: <input type="text" name="login"></div>
                <div class="logowanie">Hasło: <input type="password" name="passwd"></div>
                <input type="submit" value="Zaloguj">



            </form>
            
           

            
                 
            
        
            
        </div>










    </article>





</body>

</html>
