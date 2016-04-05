<h2>Register</h2>

<form name="loginForm" method="post" action="registeruser.php">
    <input type='hidden' name='submitted' id='submitted' value='1'/>
    <input type='text' name='first_name' id='first_name' placeholder="first Name" maxlength="50" /><br/>
    <input type='text' name='last_name' id='last_name' placeholder="Last Name" maxlength="50" /><br/>
    <input type='text' name='email' id='email' placeholder="email address" maxlength="50" /><br/>
    <input type='password' name='password' id='password' placeholder="password" maxlength="50" /><br/>
    <input type='password' name='passwordconfirm' id='passwordconfirm' placeholder="confirm password" maxlength="50" /><br/>
    <select name="campus_id" id="campus_id">
        <option value="">Select Campus</option>
        <option value="1" name="1">Brisbane</option>
        <option value="2" name="2">Byron Bay</option>
        <option value="3" name="3">Sydney</option>
        <option value="4" name="4">Adelaide</option>
        <option value="5" name="5">Melbourne</option>
        <option value="6" name="6">Perth</option>
        <option value="7" name="7">Online</option>
    </select><BR>
    <input type='submit' name='Submit' value='Submit' />
</form><BR>
  <a href='index.php'>Back to home</a>