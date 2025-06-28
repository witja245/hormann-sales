import {Vue} from 'ui.vue';

const Coloras = Vue.component('Coloras', {
  name: 'Coloras',
  template: `
        <div class="calculator__result-item calculator__result-item_start calculator__result-item-color">
            <div class="calculator__row d-f-sb">
                <div class="calculator__col">
                    <div class="calculator__result-subtitle">Стандартные цвета</div>
<!--                    <div class="calculator__result-item-name" style="margin-bottom: 8px">-->
<!--                        {{ selectedColor }}-->
<!--                    </div>--> 
                    <div class="calculator__row d-f f-w">
                        <label
                                v-for="col in colorData"
                                :key="col.id"
                                v-if="col.available === true || col.available === undefined"
                                :style="{backgroundImage: 'url('+col.img+')'}"
                                class="calculator__col calculator__col-color d-f-c-c"
                        >
                            <input
                                    type="radio"
                                    :disabled="col.available !== true && col.available !== undefined"
                                    v-model="colorId"
                                    @change="selected(colorId)"
                                    :value="col.id"
                            >
                            <span style="border: 1px solid #003a7d"></span>
                        </label>
                    </div>
                </div>
                
                <div class="calculator__col" v-if="false">
                    <div class="calculator__result-subtitle">Дополнительные +1872 ₽</div>
                    <div class="calculator__result-item-name" style="margin-bottom: 8px">
                        {{ selectedColor }}
                    </div>
                    <div class="calculator__row d-f f-w">
                        <label
                                v-for="col in colorData"
                                :key="col.id"
                                v-if="col.available"
                                :style="{backgroundImage: 'url('+col.img+')'}"
                                class="calculator__col calculator__col-color d-f-c-c"
                        >
                            <input
                                    type="radio"
                                    :disabled="!col.available"
                                    v-model="colorId"
                                    @change="selected(colorId)"
                                    :value="col.id"
                            >
                            <span style="border: 1px solid #003a7d"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
	`,
  data() {
    return {
      colorId: null,
      selectedColor: '',
    }
  },
  props: {
    colorData: {
      type: Array,
      default() {
        return []
      }
    },
  },
  methods: {
    selected(id) {
      this.selectedColor = this.colorData.find(el => el.id === id).name;
      this.$emit('recalculate', {'name': 'color', 'selected': id})
    }
  }
});

export default Coloras;