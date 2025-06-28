import {Vue} from 'ui.vue';

const Surfaceas = Vue.component('Surfaceas', {
    name: 'Surfaceas',
    template: `
        <div class="calculator__result-item calculator__result-item-surface">
            <div class="d-f f-w">
                <label v-for="surfac in surfaceData" :key="surfac.id" :class="{'selected': surfaceId == surfac.id}" v-if="surfac.available === true || surfac.available === undefined">
                   <span class="calculator__result-item-img">
                        <img 
                            :src="surfac.img || '/static/src/images/calculator/test.png'" 
                            alt="" 
                            class="calculator__result-item-img"
                        >
                    </span>
                    <div class="calculator__result-item-name" style="display: flex;align-items: center;">{{ surfac.name }} <span style="display: inline;margin-left: 5px;" :data-hint="surfac.description"></span></div>
                    <input 
                        type="radio" 
                        v-model="surfaceId"
                        @change="selected(surfaceId)"
                        :value="surfac.id"
                    >
                </label>
            </div>
        </div>
    `,
    data() {
        return {
            surfaceId: null,
            selectedSurface: '',
        }
    },
    props: {
        surfaceData: {
            type: Array,
            default() {
                return []
            }
        },
    },
    methods: {
        selected(id) {
            this.selectedSurface = this.surfaceData.find(el => el.id === id).name;
            this.$emit('recalculate', { 'name': 'surface', 'selected': id })
        }
    }
});

export default Surfaceas;
