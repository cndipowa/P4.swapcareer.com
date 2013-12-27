<script>
function check(form){
    if (form.message.value.trim() === ""){
        return false
    }
}
</script>
</br></br>


<div>Please Add Your Comments on this page </div></br>

<form action='/posts/p_add' method="POST" onsubmit="return check(this)">
    <textarea id="message" name='content' rows="6" cols="60"></textarea></br>
    <input type="submit" value="Add New Post" />
</form>

