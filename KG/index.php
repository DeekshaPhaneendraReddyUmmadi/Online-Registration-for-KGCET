<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>HOME</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: hsl(186.72deg 93.8% 35.43%);
        }
        section {
            padding: 20px;
        }
        section {
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }
        
        .custom-button {
            display: inline-block;
            padding: 17px 40px;
            border-radius: 50px;
            cursor: pointer;
            border: 0;
            background-color: white;
            box-shadow: rgb(0 0 0 / 5%) 0 0 8px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-size: 15px;
            transition: all 0.5s ease;
            text-decoration: none; /* Remove underline */
            color: inherit; /* Inherit text color */
            text-align: center; /* Center text */
        }

        .custom-button:hover {
            letter-spacing: 3px;
            background-color: hsl(261deg 80% 48%);
            color: hsl(0, 0%, 100%);
            box-shadow: rgb(93 24 220) 0px 7px 29px 0px;
        }

        .custom-button:active {
            letter-spacing: 3px;
            background-color: hsl(261deg 80% 48%);
            color: hsl(0, 0%, 100%);
            box-shadow: rgb(93 24 220) 0px 0px 0px 0px;
            transform: translateY(10px);
            transition: 100ms;
        }  

        .button-container {
            text-align: right; /* Align buttons to the right */
            max-width: 300px; /* Set the maximum width as needed for your square box */
            margin: 0 auto; /* Center the container */
        }

        .button-container .custom-button {
            width: 100%; /* Make buttons fill the container width */
            padding: 10px;
            margin: 10px 0; /* Adjust the margin as needed */
            font-size: 16px;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>
<div class="container">
    <div class="row my-3">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-12">
                    <div class="vision-mission">
                        <h2>Vision</h2>
                        <p>To evolve as center of repute for providing quality academic programs amalgamated with creative learning and research excellence to produce graduates with leadership qualities, ethical and human values to serve the nation.
                        To produce highly competent professional leaders for contributing to Socio-economic development of region and the nation.</p>

                        <h2>Mission</h2>
                        <p>M1:To provide high quality education with enriched curriculum blended with impactful teaching-learning practices.
                        M2:To promote research, entrepreneurship and innovation through industry collaborations.
                        M3:To produce highly competent professional leaders for contributing to Socio-economic development of region and the nation.
                        To produce highly competent professional leaders for contributing to Socio-economic development of region and the nation.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="button-container">
                        <a class="custom-button" href="form.php">Application Form</a>
                        <a class="custom-button" href="print_application_form.php">Print Application</a>
                        <a class="custom-button" href="down_sample.php">Download Hall Ticket</a>
                        <a class="custom-button" href="result_form.php">Results</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>