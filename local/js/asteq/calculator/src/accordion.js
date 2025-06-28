import {Vue} from 'ui.vue';

const Accordion = Vue.component('Accordion', {
    name: 'Accordion',
    template: `
		<div class="as-accordion">
		    <slot></slot>
		</div>
	`,
});

export default Accordion;