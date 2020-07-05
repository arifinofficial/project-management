// Vue.directive('select2', {
//     inserted(el) {
//         $(el).on('select2:select', () => {
//             const event = new Event('change', { bubbles: true, cancelable: true });
//             el.dispatchEvent(event);
//         });

//         $(el).on('select2:unselect', () => {
//             const event = new Event('change', {bubbles: true, cancelable: true})
//             el.dispatchEvent(event)
//         })
//     },
// });

export default {
    mounted() {
        var vm = this;

        $("#start_date").on("dp.change", (e) => {
            vm.inputs.job.start = e.date.format('YYYY-MM-DD HH:mm:ss');
            
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });

        $("#end_date").on("dp.change", (e) => {
            vm.inputs.job.end = e.date.format('YYYY-MM-DD HH:mm:ss');

            $('#start_date').data("DateTimePicker").maxDate(e.date);
        });
    },
};