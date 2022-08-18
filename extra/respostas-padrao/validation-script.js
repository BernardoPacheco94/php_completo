function passValidation(){

    var input_pass = document.getElementById('input_pass')
    var input_confirm_pass = document.getElementById('input_confirm_pass')

    if (input_pass.value !== input_confirm_pass.value){
        alert('As senhas não conferem')
        input_pass.value = ''
        input_confirm_pass.value =''
    }
}