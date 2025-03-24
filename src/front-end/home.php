<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Data</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
        <script>
            async function fetchAdmin() {
                try {
                    let params = new URLSearchParams({ name: "Ben" });
                    let response = await fetch(`/api/users.php?${params.toString()}`, {
                        method: "GET",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    let data = await response.json();

                    if (Array.isArray(data) && data.length > 0) {
                        data = data[0];

                        let body = document.getElementById("db-test");
                        let row = document.createElement("tr");

                        let tname = document.createElement("td");
                        let tdesc = document.createElement("td");
                        let tadmin = document.createElement("td");

                        tname.textContent = data["Name"] || "N/A";
                        tdesc.textContent = data["Description"] || "N/A";
                        tadmin.textContent = data["Admin"] === 1 ? "Yessir" : "Noway";

                        row.appendChild(tname);
                        row.appendChild(tdesc);
                        row.appendChild(tadmin);

                        body.appendChild(row);
                    } else {
                        console.error("No user data found");
                    }
                } catch (error) {
                    console.error("Error fetching user data:", error);
                }
            }

            window.onload = fetchAdmin;
        </script>
    </head>
    <body>
        <h1>Hello.</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>isAdmin</th>
                </tr>
            </thead>
            <tbody id="db-test">
            </tbody>
        </table>
    </body>
</html>