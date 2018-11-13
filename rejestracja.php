<?php

    session_start();
    require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);



  if(isset($_POST['email'])){
       
       //udana walidacja? załóżmy że tak
       $wszystko_ok = true;
       
       //sprawdzenie poprawnosci nazwy uzytkownika
       $login = $_POST['login'];
        
       
      
           
           //sprawdzenie dlugosci loginu
           if(strlen($login) < 3 || (strlen($login) > 20)){
               
               $wszystko_ok = false;
               $_SESSION['e_login'] = "Nazwa użytkownika musi posiadać od 3 do 20 znaków!";
               
           }
      
            //sprawdzzenie poprawnosci znakow
            if(ctype_alnum($login) == false){
                
                $wszystko_ok = false;
                $_SESSION['e_login'] = "Nazwa użytkownika może składać się tylko z liter i cyfr (bez polskich znaków)";
            }
      
      
      
      
      //sprawdz poprawnosc adresu email
      
      $email = $_POST['email'];
      $emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
      
      if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)){
          
          $wszystko_ok = false;
          $_SESSION['e_email'] = "Podaj poprawny email!";
          
          
      }
      
     
      
      
      
      
      
      
      
      // sprawdz poprawnosc hasla
      
      $passwd = $_POST['passwd'];
      $passwd1 = $_POST['passwd1'];
      
      if((strlen($passwd) < 8 ) || (strlen($passwd) > 20)){
          $wszystko_ok = false;
          $_SESSION['e_passwd'] = "Hasło powinno mieć 8-20 znaków";
          
      }
      
      if($passwd != $passwd1){
          
         $wszystko_ok = false;
        $_SESSION['e_passwd'] = "Podane hasła są różne";
      }
      
      $passwd_hash = password_hash($passwd, PASSWORD_DEFAULT);
      
      //czy regulamin jest zaakceptowany
      
      $check = $_POST['check'];
      if(!isset($check)){
          
          $wszystko_ok = false;
        $_SESSION['e_check'] = "Musisz zaakceptować regulamin!";
          
      }
      
      
      
      
               
            if($wszystko_ok == true){
                
                //walidacja udana, dodajemy konto uzytkownika
                
                
                
                if($polaczenie -> connect_errno!=0){
                    
                    echo "Error".$polaczenie -> connect_errno;
                }else{
                    
                    
                    $zapytanie_sprawdz_czy_istnieje = "Select login, email from konta where email like '".$email."' or login like '".$login."'";
                    
                    if($rezultat = $polaczenie->query($zapytanie_sprawdz_czy_istnieje)){
                        
                        $ile = $rezultat->num_rows;
                        if($ile > 0){
                            echo "Istnieje uzytkownik o podanych danych";
                        }else{
                            
                             $zapytanie_rejestracja = "insert into konta(login,haslo,email) values ('".$login."','".$passwd_hash."','".$email."')";
                    
                    if($polaczenie->query($zapytanie_rejestracja)){
                        header("Location: index.php");
                   
                        }
                        
                    }
                    
                   
                    
                    
                    
                    
                    
                    }
                    else{
                        echo "dodawanie uzytkownika nie powiodlo sie";
                    }
                    
                }
              
                
                
                
                
                
                exit();
                
            }
           
       
   }






?><!DOCTYPE HTML>
<html lang="pl">

    <head>
        
        <meta charset="utf-8">
        <link rel="stylesheet"  type="text/css" href="style.css">
        <title>Lets Play - logowanie</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        
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
                
                
                <!--mechanizm tworzenia nowego usera -->
                
                
                <div id="logowanie">
                
                    <form name="logo" method="post" action="rejestracja.php">
                        
                        <div class="pole">Podaj nazwe użytkownika:</div>
                        <div class="pole"> <input type="text" name="login"><br></div>
                        
                        <?php 
               
                            if(isset($_SESSION['e_login'])){
                                
                                echo '<div class="error">' . $_SESSION['e_login'] . '</div>';
                                unset($_SESSION['e_login']);
                            }
                        ?>
                        
                        <div class="pole">E-mail:</div>
                        <div class="pole"> <input type="text" name="email"><br></div>
                        
                        <?php 
               
                            if(isset($_SESSION['e_email'])){
                                
                                echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
                                unset($_SESSION['e_email']);
                            }
                        ?>
                        
                        <div class="pole">Twoje hasło: </div>
                        <div class="pole">  <input type="password" name="passwd"><br></div>
                        
                        <?php 
               
                            if(isset($_SESSION['e_passwd'])){
                                
                                echo '<div class="error">' . $_SESSION['e_passwd'] . '</div>';
                                unset($_SESSION['e_passwd']);
                            }
                        ?>
                        
                        <div class="pole">Powtórz hasło:  </div>
                        <div class="pole"> <input type="password" name="passwd1"><br></div>
                        
                        <label><div class="pole"> <input type="checkbox" name="check"><br>  Akceptuje regulamin <br><br></div></label>
                        <?php 
               
                            if(isset($_SESSION['e_check'])){
                                
                                echo '<div class="error">' . $_SESSION['e_check'] . '</div>';
                                unset($_SESSION['e_check']);
                            }
                        ?>
                        
                        <div class="pole">    <div class="g-recaptcha" data-sitekey="6Le1-HQUAAAAAHj3HRtOXgqcVBY6HWgSoWjcER66"></div></div>
                        
                        
                        
                        <div class="pole"> <input type="submit" value="Zarejestruj się" name="zatwierdz"><br></div>



                       
                        

                    </form>
                    
                    
            
            
            
                </div>
            
            
            </div>
        
        
        
        
        
        </article>
        
        
        
    
    
    </body>

</html>