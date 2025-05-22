<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FancyBox Data Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
</head>
<body>
    <a href="#dataForm" data-fancybox>Open Form</a>

    <!-- Form inside FancyBox -->
    <div style="display: none;" id="dataForm">
        <form id="fancyForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name"><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br><br>
            <button type="button" id="submitButton">Submit</button>
        </form>
    </div>

    <!-- Result display on parent page -->
    <div id="result"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#submitButton").click(function() {
                // Collect form data
                var formData = {
                    name: $("#name").val(),
                    email: $("#email").val()
                };

                // Close the FancyBox
                $.fancybox.close();

                // Post the data to the parent page
                $("#result").html("Name: " + formData.name + "<br>Email: " + formData.email);

                // Optionally, send data to the server via AJAX
                /*
                $.ajax({
                    url: 'your-server-endpoint.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle the response from the server
                    }
                });
                */
            });
        });
    </script>

	Hello Testing
</body>
</html>
