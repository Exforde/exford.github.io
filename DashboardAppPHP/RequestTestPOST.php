<!DOCTYPE html>
<html>
    <body>

        <h2>Get JSON Data from a PHP Server</h2>
        <p id="demo"></p>

        <script>

            let tmp = {data: {uid: "test"}};

            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                document.getElementById("demo").innerHTML = this.responseText;
            }
            xmlhttp.open("POST", "http://DashboardAppPHP/ApiHardwareBridge.php", true);
            xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8"); 
            xmlhttp.send(JSON.stringify(tmp));
        </script>

    </body>
</html>
