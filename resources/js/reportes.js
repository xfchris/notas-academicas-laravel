/**
 * Crea tabla de reporte usando libreria datatable
 */
function crearTablaDeReporte(){
    let oTable = $('#tablaReporte').DataTable({
        "order":[[0, "desc"]]
    })
    
    
    $('#buscarReporte').change(function(){
          oTable.search($(this).val()).draw() ;
    })
    
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( $('#filtrarReporteMin').val(), 10 );
            var max = parseInt( $('#filtrarReporteMax').val(), 10 );
            var total = parseFloat( data[7] ) || 0; // se usa para la columna total
     
            if ( ( isNaN( min ) && isNaN( max ) ) ||
                 ( isNaN( min ) && total <= max ) ||
                 ( min <= total   && isNaN( max ) ) ||
                 ( min <= total   && total <= max ) )
            {
                return true;
            }
            return false;
        }
    );
    
    $('#filtrarReporteMin, #filtrarReporteMax').change( function() {
        oTable.draw()
    } )
}

crearTablaDeReporte()