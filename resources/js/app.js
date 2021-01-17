import './bootstrap';
import Swal from 'sweetalert2'
import './reportes'
    
//boton espere
document.querySelectorAll('.btn-espere-submit').forEach((elemento)=>{
    elemento.onclick = function(){
        if (this.form.checkValidity()){
            this.innerHTML='Espere...'
            this.disabled = true
            this.form.submit()
        }
    }
})