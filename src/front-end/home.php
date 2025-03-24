<table?php
session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            async function fetchAdmin(){
                let params = new URLSearchParams({ name: "Ben" });
                //Config issue 
                let response = await fetch(`/api/users.php?${params.toString()}`, {
                    method: "GET",
                    headers: { "Content-Type": "application/x-www-form-urlencoded"}
                });

                let data = await response.json();
                
                let body = document.getElementById("db-test");
                let row = document.createElement("tr");
                
                let tname = document.createElement("td");
                let tdesc = document.createElement("td");
                let tadmin = document.createElement("td");

                tname.textContent = data["Name"];
                tdesc.textContent = data["Description"];
                tadmin.textContent = data["Admin"] == 1 ? "Yessir" : "Noway";
            }

            window.onload = fetchAdmin;
        </script>
    </head>
    <body>
        <h1>Hello.</h1>
        <table >
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>isAdmin</th>
                </tr>
            </thead>
            <tbody id = "db-test">
            </tbody>
        </table>
    </body>
</html>