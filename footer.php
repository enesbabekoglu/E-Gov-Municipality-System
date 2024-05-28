<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>

<script>
    function DataSendLoad(){
        Swal.fire({
                title: 'Yükleniyor...',
                text: "lütfen bekleyin",
                allowOutsideClick: false,
                showCancelButton: false, // Cancel butonunu gizler
                showConfirmButton: false, // Onay butonunu gizler
                willOpen: () => {
                    Swal.showLoading();
                }
            });
    }

    function DilDegistir(lang){

        $.ajax({
            url: 'ajax/settings.php', // AJAX isteğinin gideceği adres
            type: "POST",
            data: {"changelang": "true", "lang": lang},
            success: function (response){

                var data = JSON.parse(response);

                if(data.status == "success"){
                    window.location.reload();
                }else{
                    Swal.fire(data.title, data.text, data.status);
                }

            }
        });

    }
</script>

</body>

</html>