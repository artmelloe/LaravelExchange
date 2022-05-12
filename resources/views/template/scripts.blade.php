<script src="{{ asset('js/app.js') }}"></script>
<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    function equalValues() {
        var value = document.getElementById('fee_amount_greater_value').value;
        document.getElementById('fee_amount_less_value').setAttribute('max', value);
    }
</script>
