<?php
// Initialize the session
session_start();
session_destroy();
session_start();
$_SESSION['email'] = "";

// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../welt");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, name, istAdmin, password FROM mitarbeiter WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $name, $istAdmin, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct. The session is already active
                            // (started at the top of this file), so we must NOT
                            // call session_start() again here.

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["name"] = $name;
                            $_SESSION["istAdmin"] = $istAdmin;

                            // Redirect user to index page
                            header("location: ../welt");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="../images/verwaltung.png">
    <meta name="author" content="Olivier Luethy">
    <script src="../public/js/tailwind.js"></script>
</head>
<body class="bg-zinc-950 text-zinc-100 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-sm bg-zinc-900 border border-zinc-800 rounded-xl shadow-2xl p-6">
        <div class="flex items-center gap-2 mb-6">
            <img src="../images/verwaltung.png" alt="" class="h-8 w-8">
            <span class="font-semibold tracking-tight">Aufträgeverwaltung</span>
        </div>
        <h2 class="text-lg font-semibold mb-1">Login</h2>
        <p class="text-sm text-zinc-400 mb-5">Please fill in your credentials to login.</p>
        <form action="login" method="post" class="space-y-4">
            <div>
                <label class="block text-xs text-zinc-400 mb-1">Email</label>
                <input type="text" name="email" value="<?php echo e($email); ?>"
                       class="w-full bg-zinc-800 border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 <?php echo (!empty($email_err)) ? 'border-red-500' : 'border-zinc-700'; ?>">
                <?php if (!empty($email_err)) : ?><p class="text-red-400 text-xs mt-1"><?php echo e($email_err); ?></p><?php endif; ?>
            </div>
            <div>
                <label class="block text-xs text-zinc-400 mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full bg-zinc-800 border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 <?php echo (!empty($password_err)) ? 'border-red-500' : 'border-zinc-700'; ?>">
                <?php if (!empty($password_err)) : ?><p class="text-red-400 text-xs mt-1"><?php echo e($password_err); ?></p><?php endif; ?>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">Login</button>
            <p class="text-sm text-zinc-400">Don't have an account? <a href="../register" class="text-indigo-400 hover:text-indigo-300">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
