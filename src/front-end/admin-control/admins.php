<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in'])) {
    // Redirect to login page if not logged in
    header('Location: /login');
    exit;
}

  
include __DIR__ . '/../global/get-nav.php';
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/admins.css">
    <link rel="stylesheet" type="text/css" href="../front-end/global/css/nav.css">
    </head>
    <body>
    <?php get_nav() ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <aside onclick="showPanel('messages')" class="p-3 hover-lager" style="width: 250px;" id="messages">
                    All messages
                </aside>
                <aside onclick="showPanel('banned-messages')" class="p-3 hover-lager" style="width: 250px;" id="banned-messages">
                    All banned messages
                </aside>
                <aside onclick="showPanel('reviews')" class="p-3 hover-lager" style="width: 250px;" id="reviews">    
                    All reviews
                </aside>
                <aside onclick="showPanel('banned-reviews')" class="p-3 hover-lager" style="width: 250px;" id="banned-reviews">
                    All banned reviews
                </aside>
                <aside onclick="showPanel('all-users')" class="p-3 hover-lager" style="width: 250px;" id="all-users">
                    All users
                </aside> 
            </div>

            <div class="col-9 p-4">
                <div id="panel-messages" class="content-panel active">
                    <h3>All Messages</h3>
                    <p>Display all messages here from the database.</p>
                    <table class="table messages-table">
                        <thead>
                            <tr>
                                <th scope="col">ReceiverId</th>
                                <th scope="col">SenderId</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                
                <div id="panel-banned-messages" class="content-panel">
                    <h3>All removed messages</h3>
                    <p>Display all removed messages here from the database.</p>
                    <table class="table messages-table">
                        <thead>
                            <tr>
                                <th scope="col">ReceiverId</th>
                                <th scope="col">SenderId</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

                <div id="panel-reviews" class="content-panel">
                    <h3>All reviews</h3>
                    <p>Display all reviews here from the database..</p>
                    <table class="table reviews-table">
                        <thead>
                            <tr>
                                <th scope="col">userId</th>
                                <th scope="col">serviceId</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Response</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    
                </div>

                <div id="panel-banned-reviews" class="content-panel">
                <h3>All removed reviews</h3>
                    <p>Display all removed reviews here from the database..</p>
                    <table class="table reviews-table">
                        <thead>
                            <tr>
                                <th scope="col">userId</th>
                                <th scope="col">serviceId</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Response</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

                <div id="panel-all-users" class="content-panel">
                    <h3>All users</h3>
                    <p>Display all users here from the database..</p>
                    <table class="table users-table">
                        <thead>
                            <tr>
                                <th scope="col">userName</th>
                                <th scope="col">userType</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <script type="application/javascript" src="js/admins.js"></script>
    </body>