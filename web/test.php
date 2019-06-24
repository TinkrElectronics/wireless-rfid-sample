<?php include_once('index.php'); ?>

<html>
    <head>
        <title><?=Config::$title;?></title>
        <style>
            table {
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid black;
            }

            td{
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <table id="tinkr-table">
            <tr><td>UID</td><td>Date & Time</td></tr>
        </table>
        
        <script>
            var count = 0;
            
            function loadJSON() {
                var data_file = "api/data.json";
                var http_request = new XMLHttpRequest();
                try{
                    http_request = new XMLHttpRequest();
                }catch (e) {
                    try{
                        http_request = new ActiveXObject("Msxml2.XMLHTTP");
                    }catch (e) {
                        try{
                            http_request = new ActiveXObject("Microsoft.XMLHTTP");
                        }catch (e) {
                            alert("Your browser broke!");
                            return false;
                        }
                    }
                }
                
                http_request.onreadystatechange = function() {
                
                    if (http_request.readyState == 4  ) {
                        var jsonObj = JSON.parse(http_request.responseText);
                        var table = document.getElementById("tinkr-table");
                        if(count < jsonObj.length){
                            for(i = count; i < jsonObj.length; i++){
                                console.log(jsonObj[i]);
                                
                                var row = table.insertRow(i+1);
                                var cell1 = row.insertCell(0);
                                var cell2 = row.insertCell(1);
                                cell1.innerHTML = jsonObj[i]['uid'];
                                cell2.innerHTML = jsonObj[i]['datetime'];
                                count++;
                            }
                        }
                    }
                }
                
                http_request.open("GET", data_file, true);
                http_request.send();
            }
            
            setInterval(function(){
                loadJSON();
            }, 1000);
        </script>
    </body>
</html>