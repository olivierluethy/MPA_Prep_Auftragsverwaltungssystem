<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email adress.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM mitarbeiter WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        $sql = "INSERT INTO mitarbeiter (email, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);

            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if(mysqli_stmt_execute($stmt)){
                header("location: login");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        <h2 class="text-lg font-semibold mb-1">Sign Up</h2>
        <p class="text-sm text-zinc-400 mb-5">Please fill this form to create an account.</p>
        <form action="register" method="post" class="space-y-4">
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
            <div>
                <label class="block text-xs text-zinc-400 mb-1">Confirm Password</label>
                <input type="password" name="confirm_password"
                       class="w-full bg-zinc-800 border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 <?php echo (!empty($confirm_password_err)) ? 'border-red-500' : 'border-zinc-700'; ?>">
                <?php if (!empty($confirm_password_err)) : ?><p class="text-red-400 text-xs mt-1"><?php echo e($confirm_password_err); ?></p><?php endif; ?>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">Submit</button>
                <button type="reset" class="px-4 py-2 rounded-md text-sm bg-zinc-800 hover:bg-zinc-700 text-zinc-200">Reset</button>
            </div>
            <p class="text-sm text-zinc-400">Already have an account? <a href="login" class="text-indigo-400 hover:text-indigo-300">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
