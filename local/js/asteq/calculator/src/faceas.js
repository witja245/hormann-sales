import {Vue} from 'ui.vue';

const Faceas = Vue.component('Faceas', {
    name: 'Faceas',
    template: `
        <div class="calculator__result-item calculator__result-item-face">
            <div class="d-f f-w">
                <label v-for="face in faceData" :key="face.id" v-if="face.available === true || face.available === undefined"
                :class="{'selected': faseId == face.id}">
                    <span class="calculator__result-item-img">
                        <img :src="face.img || '/static/src/images/calculator/test.png'" alt="">
                    </span>
                    <div class="calculator__result-item-name">{{ face.name }}</div>
                    <span v-if="face.available !== true && face.available !== undefined" class="calculator__unvailable">Недоступно</span>
                    <input
                        type="radio"
                        :disabled="face.available !== true && face.available !== undefined"
                        v-model="faseId"
                        @change="selected(faseId)"
                        :value="face.id"
                    >
                </label>
            </div>
        </div>
    `,
    data() {
        return {
            faseId: null,
            selectedFace: '',
        }
    },
    props: {
        faceData: {
            type: Array,
            default() {
                return []
            }
        },
    },
    methods: {
        selected(id) {
            this.selectedFace = this.faceData.find(el => el.id === id).name;
            this.$emit('recalculate', { 'name': 'face', 'selected': id })
        }
    }
});

export default Faceas;
