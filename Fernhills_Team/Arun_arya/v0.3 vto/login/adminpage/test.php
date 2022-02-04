<!DOCTYPE html>
<html>

<head>
    <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <script src="script.js"></script>
</head>

  <body>
  
    <div class="modal fade" id="confirma-deletar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Alerta</h4>
                </div>
            
                <div class="modal-body">
                    <p>Você realmete deseja deletar este arquivo?</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Deletar</a>
                </div>
            </div>
        </div>
    </div>


  <button type="button" class="btn btn-danger btn-custom" name="deletar" data-toggle="modal" data-target="#confirma-deletar" id="<? echo $valor->set_cod; ?>" data-href="/delete.php?id=<? echo $valor->set_cod; ?>"><i class="fa fa-trash"></i>Deletar</button>


    <script>
        $('#confirma-deletar').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
	<script>
       /* $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            
            $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });*/
		
		
$('#confirma-deletar').on('show.bs.modal', function (e) {
	console.log("hello");
 var table = $(e.relatedTarget).data('href');
  var href = '?remove=' + table;
  $('.btn-danger', this).attr('href', href);
  console.log(href);
});

// Simulate "clear" button click to alert href value
$('#confirma-deletar').on('click', function (e) {
  e.preventDefault();
  alert(e.target.pathname + e.target.search);
});
    </script>
  </body>

</html>