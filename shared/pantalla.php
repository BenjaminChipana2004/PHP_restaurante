<?php
class pantalla{
    protected function cabeceraShow($titulo){
        ?>
        <html>
            <head>
                <title>
                    <?php echo strtoupper($titulo); ?>
                </title>
                <link rel="icon" href="../img/icon-php.png">
                <?php
                if($titulo == "Iniciar Sesion"){
                    ?><link rel="stylesheet" href="../CSS/estilos_login.css"><?php
                }
                else
                {
                    ?><link rel="stylesheet" href="../CSS/estilos.css"><?php
                }
                ?>
            </head>
            <body style="margin: 0; padding: 0; min-height: 100vh; display: flex; flex-direction: column;">
                
                <header style="
                    background-color: #0b0f19; 
                    padding: 15px 20px; 
                    width: 100%; 
                    box-sizing: border-box; 
                    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                    text-align: center;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                ">
                    <h1 style="
                        margin: 0; 
                        font-size: 15px; 
                        text-transform: uppercase; 
                        letter-spacing: 1.5px; 
                        color: #9ca3af;
                        font-weight: 600;
                    ">
                        📖 Curso Analisis y Diseño de sistemas - Ing de sistemas
                    </h1>
                </header>

        <?php
    }

    protected function piePaginaShow(){
        ?>
                <footer style="
                    background-color: #0b0f19; 
                    padding: 15px 20px; 
                    margin-top: auto; 
                    width: 100%; 
                    box-sizing: border-box; 
                    border-top: 1px solid rgba(255, 255, 255, 0.08);
                ">
                    <div style="
                        max-width: 1200px; 
                        margin: 0 auto; 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        gap: 30px; 
                        flex-wrap: wrap;
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    ">
                        <h2 style="
                            margin: 0; 
                            font-size: 12px; 
                            text-transform: uppercase; 
                            letter-spacing: 1.5px; 
                            color: #9ca3af;
                        ">Autores:</h2>
                        
                        <div style="
                            margin: 0; 
                            font-size: 13px; 
                            color: #e5e7eb; 
                            display: flex; 
                            gap: 25px; 
                            flex-wrap: wrap;
                        ">
                            <span>👨‍💻 Chipana Bandera, Benjamin Adriano</span>
                            <span>👨‍💻 Mandujano, Wilfredo</span>
                            <span>👨‍💻 Alfaro Mendoza, Jose Luis</span>
                        </div>
                    </div>
                </footer>
            </body>
        </html>
        <?php
    }
}
?>