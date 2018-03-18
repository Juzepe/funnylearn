<script>
	function getLessons(selectObject) { 
        var data = {
            book_id: selectObject.value
        };

        $.get("{{url('admin/getLessons')}}", data, function( response ) {
            $('#lesson').html(response);
        });
    }
</script>