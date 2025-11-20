@if(session()->has('Acccept_Request'))
<script>
Swal.fire({
    title: "Raport został zaakceptowany!",
    text: "Raport został zaakcptowany i pracownik zostanie z niego rozliczony.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6",
    background: "#f9f9f9",
    customClass: {
        popup: "swal-custom-popup",
        title: "swal-custom-title",
        confirmButton: "swal-custom-button"
    },
    allowOutsideClick: false,
    allowEscapeKey: true,
    allowEnterKey: true
})
</script>

@endif

@if(session()->has('Deny_Request'))
<script>
Swal.fire({
    title: "Raport został odrzucony!",
    text: "Raport został odrzucony",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6",
    background: "#f9f9f9",
    customClass: {
        popup: "swal-custom-popup",
        title: "swal-custom-title",
        confirmButton: "swal-custom-button"
    },
    allowOutsideClick: false,
    allowEscapeKey: true,
    allowEnterKey: true
})
</script>

@endif

@if(session()->has('Raport_Store'))
<script>
Swal.fire({
    title: "Wniosek złożony pomyślnie!",
    text: "Dziękujemy za złożenie wniosku. Możesz teraz śledzić jego status w systemie.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6",
    background: "#f9f9f9",
    customClass: {
        popup: "swal-custom-popup",
        title: "swal-custom-title",
        confirmButton: "swal-custom-button"
    },
    allowOutsideClick: false,
    allowEscapeKey: true,
    allowEnterKey: true
})
</script>
@endif

@if(session()->has('Edit_Success'))
<script>
Swal.fire("Edycja zakończona sukcesem!");
</script>
@endif

@if(session()->has('Create_Success'))
<script>
Swal.fire({
  title: "Dobra robota!",
  text: "Nowy wpis został dodany do bazy!",
  icon: "success"
});
</script>
@endif

@if(session()->has('importFinished'))
<script>
Swal.fire({
    title: "Pracownicy poprawnie zaimportowani!",
    text: "Dziekuje! Pracownicy zostali poprawnie zaimportowani do systemu.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6",
    background: "#f9f9f9",
    customClass: {
        popup: "swal-custom-popup",
        title: "swal-custom-title",
        confirmButton: "swal-custom-button"
    },
    allowOutsideClick: false,
    allowEscapeKey: true,
    allowEnterKey: true
})
</script>
@endif

<script>
    function confirmAction(method, reportId, message = "Na pewno chcesz wykonać tę akcję?", confirmButtonText = "Tak, kontynuuj!", icon = "warning") {
        Swal.fire({
            title: 'Czy na pewno?',
            text: message,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Anuluj'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call(method, reportId);
            }
        });
    }
</script>