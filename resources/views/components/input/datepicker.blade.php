<div x-data="{
    model: @entangle($attributes->wire('model')),
    preventTyping: function() {
        this.$refs.datepicker.blur();
        this.checkReadonly();
    },
    checkReadonly: function() {
        if (!this.$refs.datepicker.hasAttribute('readonly')) {
            this.$refs.datepicker.setAttribute('readonly', true);
        }
    }
}" x-init="flatpickr($refs.datepicker, {
    dateFormat: 'Y-m-d',
    minDate: @js($attributes->get('minDate')),
    maxDate: @js($attributes->get('maxDate')),
    mode: @js($attributes->get('mode')),
    allowInput: true,
})" class="custom-date">
    <input x-ref="datepicker" type="text" x-model="model" x-on:focus="preventTyping"
        {{ $attributes->merge(['class' => 'form-control', 'readonly' => true]) }} />
</div>
