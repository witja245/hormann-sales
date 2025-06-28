import {Vue} from 'ui.vue';

const Glassas = Vue.component('Glassas', {
    name: 'Glassas',
    template: `
        <div class="calculator__result-item calculator__result-item_glass">
            <div class="d-f f-w">
                <label
                        v-for="gl in glassData"
                        :key="gl.id"
                        v-if="gl.name && (gl.available === true || gl.available === undefined)"
                        :class="{'selected': glId == gl.id}"
                >
                    <span class="calculator__result-item-img">
                        <img :src="gl.img" alt="">
                    </span>
                    <div class="calculator__result-item-name">{{ gl.name }}</div>
                    <span v-if="gl.available !== true && gl.available !== undefined" class="calculator__unvailable">Недоступно</span>
                    <input
                        type="radio" 
                        v-model="glId"
                        @change="selected(glId)"
                        :value="gl.id"
                    >
                </label>
            </div>
        </div>
    `,
    data() {
        return {
            glId: null,
            selectedGl: '',
        }
    },
    props: {
        glassData: {
            type: Array,
            default() {
                return []
            }
        },
    },
    methods: {
        selected(id) {
            this.selectedGl = this.glassData.find(el => el.id === id).name;
            this.$emit('recalculate', { 'name': 'glass', 'selected': id })
        }
    }
});

export default Glassas;