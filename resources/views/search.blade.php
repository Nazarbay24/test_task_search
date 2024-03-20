<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autocomplete Search</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="autocomplete">
    <input type="text" id="searchInput" placeholder="Search...">
    <ul id="searchResults"></ul>
</div>


<style>
    .autocomplete {
        position: relative;
        width: 500px;
        margin: 50px auto;
    }

    #searchInput {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #searchResults {
        position: absolute;
        width: 100%;
        max-height: 500px;
        overflow-y: auto;
        list-style-type: none;
        padding: 0;
        margin: 0;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 4px 4px;
    }

    #searchResults li {
        padding: 10px;
        background-color: #f9f9f9;
        cursor: pointer;
    }

    #searchResults li:hover {
        background-color: #e9e9e9;
    }

    .item {
        border: 1px solid #ccc;
        margin-bottom: 10px;
        padding: 10px;
    }

    .id, .cityName, .country, .timezone, .coordinates {
        margin-bottom: 5px;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="script.js"></script>
<script>
    $(document).ready(function(){
        $('#searchInput').keyup(function(){
            var query = $(this).val();
            if(query != ''){
                $.ajax({
                    url: '/api/search', // Замените 'search.php' на путь к вашему обработчику поиска
                    method: 'GET',
                    data: {query:query},
                    success: function(data){
                        function formatData(data) {
                            var html = '';
                            data.forEach(function(item){
                                html += '<div class="item">';
                                html += '<div class="id">ID: ' + item.id + '</div>';
                                html += '<div class="cityName">City Name: ' + item.cityName.ru + ' ('+ item.cityName.en +')</div>';
                                html += '<div class="country">Country: ' + item.country + '</div>';
                                // html += '<div class="timezone">Timezone: ' + item.timezone + '</div>';
                                // html += '<div class="coordinates">Coordinates: Lat ' + item.lat + ', Lng ' + item.lng + '</div>';
                                html += '</div>';
                            });
                            return html;
                        }

                        $('#searchResults').html(formatData(data));
                    }
                });
            }
            else {
                $('#searchResults').html(' ');
            }
        });

        $(document).on('click', '#searchResults li', function(){
            $('#searchInput').val($(this).text());
            $('#searchResults').html('');
        });
    });
</script>
</body>
</html>
