import {Vue} from 'ui.vue';

const Baseas = Vue.component('Baseas', {
    name: 'Baseas',
    template: `
        <div class="calculator__result-item calculator__result-item_motive">
            <div class="d-f f-w">
                <label v-for="bas in baseData" :key="bas.id" v-if="bas.available === true || bas.available === undefined" 
                :class="{'selected': base == bas.id}" style="margin-right: 20px">
                    <span class="calculator__result-item-img">
                        <img :src="bas.img || '/static/src/images/calculator/test.png'" alt="">
                    </span>
                    <span class="calculator__result-item-name">{{ bas.name }}</span>
                    <span v-if="bas.available !== undefined && bas.available !== true" class="calculator__unvailable">Недоступно</span>
                    <input
                            type="radio"
                            :disabled="bas.available !== undefined && bas.available !== true"
                            @change="$emit('recalculate', { 'name': 'base', 'selected': base })"
                            :value="bas.id"
                            v-model="base"
                    >
                </label>
            </div>
        </div>
	`,
    data() {
        return {
            base: null,
        }
    },
    props: {
        baseData: {
            type: Array,
            default() {
                return []
            }
        },
    },
});

export default Baseas;
