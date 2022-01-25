$(document).ready(function (e) {
    $('#profile_img_input').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#profile_pic').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
});
