<?php

// require __DIR__ . '\Service.php';

// $service = new Service();

// if (!isset($_GET['code'])) {
//     header('Location: http://auth.mercadolivre.com.br/authorization?response_type=code&client_id=3451965851253310&redirect_uri=https://moreirainformatica.000webhostapp.com/');
// }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <title>Lexart Labs</title>
</head>
<body>
    <div class="container">
        <header>
            <div class="button">
                <form id="form" name="form">
                <select class="dp-btn" name="site" id="site">
                    <option value="">Todos</option>
                    <option value="buscape">Buscapé</option>
                    <option value="ml">Mercado Livre</option>
                </select>
                <select class="dp-btn" name="category" id="category">
                    <option value="">...</option>
                    <option value="tv">TV</option>
                    <option value="geladeira">Geladeira</option>
                    <option value="celular">Celular</option>
                </select>
            </div>
            <div class="search">
                
                    <input class="form-input" type="text" name="key" id="key" placeholder="Set your text here">
                    <button type="button" class="btn-search" id="submit">Search</button>
                </form>
            </div>
        </header>
        <main id="main">
            
        </main>
    </div> 

    <script>
        $('#submit').click(function(){
            $.ajax({
                url: 'search.php',
                type: "POST",
                dataType: 'JSON',
                data: $('#form').serialize(),
                success: function( data ) {
                        console.log(data);
                        var mainHtml = '';
                        data.map(data => {
                            mainHtml += '<div class="products">';
                            mainHtml +='<div class="image">';
                            mainHtml +=   `<img src="${data.thumbnail}" alt="">`;
                            mainHtml +='</div>';
                            mainHtml +='<div class="details">';
                            mainHtml +=   `<h3>${data.title}</h3>`;
                            mainHtml +=   `<p>Categoria: ${data.category}</p>`;
                            mainHtml +=    `<span style='color: #999'>$ ${data.price}</span>`;
                            mainHtml +='</div>';
                            mainHtml +='<div class="web-link">';
                            mainHtml +=`<a href="${data.permalink}" class="btn-link">Ver</a>`;
                            mainHtml +='</div>';
                            mainHtml +='</div>';
                        });

                        $('#main').html(mainHtml);
                    
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        });
    </script>
</body>
</html>