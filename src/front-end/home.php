<?php
    #Here is example of pre-fetching something for a page.
    include("../back-end/curl_helper.php");

    $url = "http://nginx/api/users.php";
    $params = [
        'usercount' => 1,
    ];

    $queryString = http_build_query($params);

    $response = makeAPIRequest($url . "?" . $queryString, 'GET', [
        'Content-Type: application/'
    ]);


    if($response['status'] === 'success'){
        $data = $response['data'][0]; //Yes this 0 needs to be here its because the way things are structured maybe I change later

        print("User Count: " . $data['count']);
    } else {
        print($response['status'] . ": " . $response['message']);
    }


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
            //This is an example of dynamically fetching something for a page
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

                    //Everything after this point is just displaying stuff

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

        <form action="/api/users.php" method="post" id="register_form">
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                <label for="username" class="text-black-50">Enter Username</label>
            </div>
            <div class="me-2">
                <small id="usernameErr" class="text-danger"><?php echo $usernameErr ?></small>
            </div>
            <div class="form-floating mb-1 mt-1">
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                <label for="password" class="text-black-50">Enter Password</label>
            </div>
            <input type="email" class="form-control" id="email" placeholder="Temp Email" name="email" required>
            <div class="me-2">
                <small class="text-muted">Please use a mix of 8 numbers, uppercase, lowercase, and special letters.</small>
            </div>
            <div class="password-strength-meter">
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded me-2"></div>
                <div class="meter-section rounded me-2"></div>
            </div>
            <div class="me-2">
                <small id="meter-text" class="text-danger"><?php echo $passwordErr ?></small>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="password" class="form-control" id="re_password" placeholder="Repeat password" name="re_password" required>
                <label for="Repeat password" class="text-black-50">Repeat password</label>
            </div>
            <div class="me-2">
                <small id="error_message_re" class="text-danger"><?php echo $re_password ?></small>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </body>
</html>