<script>
        function deleteModel(_id) {
            event.preventDefault();
            if (confirm('Are you sure? This can\'t be undone!')) {
                document.getElementById('delete-' + _id).submit();
            }
        }
    </script>
