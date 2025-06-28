import {Vue} from 'ui.vue';

const Sizes = Vue.component('Sizes', {
    name: 'Sizes',
    template: `
        <div class="calculator__result-item calculator__result-item_start calculator__result-item_size d-f-sb f-w">
        <div class="d-f-sb" style="width: 100%">
            <div>
                <span class="d-f">
                    <div class="calculator__result-item-left">
                        <div class="calculator__result-subtitle">Ширина</div>
                        <div class="calculator__result-item-text">от {{ minWidth }} до {{ maxWidth }} мм</div>
                    </div>
                    <input 
                        type="text" 
                        v-model="innerWidth"
                        :min="minWidth"
                        :max="maxWidth"
                        class="calculator__result-size-value d-f-c-c"
                        @input="$emit('set-size', {type: 'width', value: innerWidth})"
                    >
                </span>
                <span class="calculator__validator"> {{ widthError }} </span>
<!--                <span class="calculator__validator">{{validation.firstError('selected.width')}}</span>-->
            </div>
            <div>
                <span class="d-f">
                    <div class="calculator__result-item-left">
                        <div class="calculator__result-subtitle">Высота</div>
                        <div class="calculator__result-item-text">от {{ minHeight }} до {{ maxHeight }} мм</div>
                    </div>
                    <input 
                        type="text" 
                        v-model="innerHeight"
                        :min="minHeight"
                        :max="maxHeight"
                        class="calculator__result-size-value d-f-c-c"
                        @input="$emit('set-size', {type: 'height', value: innerHeight})"
                    >
                </span>
                <span class="calculator__validator"> {{ heightError }} </span>
<!--                <span class="calculator__validator">{{validation.firstError('selected.height')}}</span>-->
            </div>
            
            <div v-if="availableSizes && availableSizes.length > 0">
             <span class="d-f">
                    <div class="as-accordion__item-btn-sizes button--primary" @click="showAvailable = !showAvailable">
                        <span class="button__text" style="padding: 11px 15px">&#9776;</span>
                    </div>
                    
                    <ul class="gate-size-select__popup" v-if="showAvailable">
                        <li class="gate-size-select__popup_item" v-for="availableSize in availableSizes" :key="availableSize" @click="setPreDefinedSizes(availableSize)">
                            {{ availableSize }}
                        </li>
                    </ul>
                    </span>
            </div>
            </div>
        </div>
	`,
    data() {
        return {
            innerWidth: '',
            innerHeight: '',
            showAvailable: false
        }
    },
    mounted() {
        this.innerWidth = this.width;
        this.innerHeight = this.height;
    },
    props: [
        'height',
        'width',
        'maxHeight',
        'minHeight',
        'maxWidth',
        'minWidth',
        'heightError',
        'widthError',
        'availableSizes'
    ],
    methods: {
        setPreDefinedSizes(size) {
            size = size.split(' x ');
            this.innerWidth = +size[0];
            this.innerHeight = +size[1];

            this.$emit('set-size', {type: 'width', value: this.innerWidth});
            this.$emit('set-size', {type: 'height', value: this.innerHeight});

            this.showAvailable = false;
        }
    },
    watch: {
        innerHeight(newVal, oldVal) {
            if (newVal) {
                this.innerHeight = newVal.replace(/\D/g, '');
                this.$emit('set-size', {type: 'height', value: this.innerHeight});
            }
        },
        innerWidth(newVal, oldVal) {
            if (newVal) {
                this.innerWidth = newVal.replace(/\D/g, '');
                this.$emit('set-size', {type: 'width', value: this.innerWidth});
            }
        },
    }
});

export default Sizes;