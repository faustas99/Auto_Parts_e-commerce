
<html>
<body>
<!-- js script for adding the options -->




<form action="/WebDev_CV/update/test1.php" target="_blank" method="POST" id="form1">
    <p>
            <input type="text" name="cur" id="bbb" />

    </p>
	
  <button type="submit" style="display:none" >Submit</button>
  <body onload="setValue();">

  


</form>
</body>
</html>
<script type="text/javascript">
    function setValue() {
        document.getElementById('bbb').value = "<?php echo $_GET['cur']; ?>";
		document.getElementById('form1').submit();
    }
</script>
<script type="text/javascript">
function submitform() {
        
		window.alert(5 + 6);
    }
</script>