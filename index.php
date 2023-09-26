<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <header
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                <use xlink:href="#bootstrap"></use>
            </svg>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">Features</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">About</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-outline-primary me-2">Login</button>
            <button type="button" class="btn btn-primary">Sign-up</button>
        </div>
    </header>
    <div class="container mt-5">

        <button class="btn_add" onclick="displayMessage()">Add user</button>
        <table class="table table-stripped table-bordered table-hover">
            <thead>
                <tr>
                    <th>user id</th>
                    <th>username</th>
                    <th>fname</th>
                    <th>lname</th>
                    <th>email</th>
                    <th>created_at</th>
                    <th>action</th>
                </tr>
            </thead>

            <tbody id="show_users">

            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


    <script>
    $(document).ready(function() {
        $('.btn_edit').on("click", function() {
            console.log("ADD CLICKED!");
        })

        editUser = function(userid) {
            window.location.href = "./edit.php?userid=" + userid;
        }

        $.ajax({
            method: "POST",
            url: "./config/services.php",
            data: {
                action: "getUsers"
            },
            dataType: "JSON",
            success: function(response) {
                let users = response.data;
                let output = "";
                // (users.length > 0) ? output += "<tr>": "";
                for (let i = 0; i < users.length; i++) {
                    console.log(users[i]);
                    output += "<tr>";
                    output += `<td>${users[i].user_id}</td>`;
                    output += `<td>${users[i].username}</td>`;
                    output += `<td>${users[i].fname}</td>`;
                    output += `<td>${users[i].lname}</td>`;
                    output += `<td>${users[i].useremail}</td>`;
                    output += `<td>${users[i].created_at}</td>`;

                    let button =
                        "<button class = 'btn btn-warning' onclick='editUser(" + users[i].user_id +
                        ")' data-id = '" +
                        users[i].user_id + "'>Edit</button>";

                    output += `<td>${button}</td>`;
                    output += "</tr>";

                }

                if (output != "") {
                    $("#show_users").html(output);
                }
            }
        });
    })
    </script>
</body>

</html>