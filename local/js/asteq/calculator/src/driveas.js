import {Vue} from 'ui.vue';

const Driveas = Vue.component('Driveas', {
    name: 'Driveas',
    template: `
        <div class="calculator__result-item calculator__result-item_start calculator__result-item-drive">
            <div class="d-f f-w">
                <div class="calculator__result-tabs">
<!--                    <div class="calculator__result-tabs-titles d-f">-->
<!--                        <div-->
<!--                                class="calculator__result-tabs-title"-->
<!--                                :class="{ 'calculator__result-tabs-title_active': driveTab === 'auto' }"-->
<!--                                @click="driveTab = 'auto'"-->
<!--                        >-->
<!--                            Автоматические-->
<!--                        </div>-->
<!--                        <div-->
<!--                                class="calculator__result-tabs-title"-->
<!--                                :class="{ 'calculator__result-tabs-title_active': driveTab === 'hand' }"-->
<!--                                @click="driveTab = 'hand'"-->
<!--                        >-->
<!--                            Ручное управление-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="calculator__result-tabs-content">
                        <div class="calculator__result-tabs-content-item d-f" v-if="driveTab === 'auto'">
                        <div class="calculator__result-tabs-col"  v-if="false">
                        <div>
                            <div class="calculator__result-tabs-col-item calculator__result-tabs-col-item_photo"></div>
                            <div class="calculator__result-item-content">
                                <div class="calculator__result-tabs-col-item calculator__result-tabs-col-item_name correct"></div>
                                <div class="calculator__result-tabs-col-item calculator__result-tabs-col-item_price correct"></div>
                                <div class="calculator__result-tabs-col-item correct">Циклы в день/час</div>
                                <div class="calculator__result-tabs-col-item correct">Пиковое усилие</div>
                                <div class="calculator__result-tabs-col-item correct">Скорость, макс.</div>
                                <div class="calculator__result-tabs-col-item correct ">Ширина, макс.</div>
                                <div class="calculator__result-tabs-col-item correct">Площадь</div>
                                <div class="calculator__result-tabs-col-item correct">Сер. оснащение</div>
                            </div>
                            </div>
                        </div>
                        <div class="calculator__result-tabs-col" :class="{'selected': driveId == 5}">
                            <label>
                                <span class="calculator__result-item-img">
                                    <img class=" calculator__result-tabs-col-item_photo calculator__result-tabs-col-item"
                                        :src="'/upload/uf/5fc/6azxb2f2w82vaebd5zm4y6tw3ugfbbgg.jpg'"
                                        alt=""
                                    >
                                </span>
                                <span class="calculator__result-item-content"> 
                                    <div class="calculator__result-item-name calculator__result-tabs-col-item">Без привода</div>
                                   
                                    <input 
                                        type="radio" 
                                        v-model="driveId"
                                        @change="selected(5)"
                                        :value="5"
                                    >
                                   
                                </span>
                            </label>
                        </div>
                        <div class="calculator__result-tabs-col" v-for="dr in driveData" :class="{'selected': driveId == dr.id}" :key="dr.id" v-if="dr.name && dr.available">
                            <label>
                                <span class="calculator__result-item-img">
                                    <img class=" calculator__result-tabs-col-item_photo calculator__result-tabs-col-item"
                                        :src="dr.img || '/static/src/images/calculator/test.png'"
                                        alt=""
                                    >
                                    <span v-if="!dr.available" class="calculator__unvailable">Недоступно</span>
                                </span>
                                <span class="calculator__result-item-content"> 
                                    <div class="calculator__result-item-name calculator__result-tabs-col-item">{{ dr.name }}</div>
                                    <span class="calculator__result-item-price calculator__result-tabs-col-item" v-if="dr.price">{{ dr.formattedPrice }}</span>
                                    <input 
                                        type="radio" 
                                        v-model="driveId"
                                        @change="selected(driveId)"
                                        :disabled="!dr.available"
                                        :value="dr.id"
                                    >
                                    <div v-if="false">
                                    <span class="calculator__result-tabs-col-item">25/10</span>
                                    <span class="calculator__result-tabs-col-item">800 H</span>
                                    <span class="calculator__result-tabs-col-item">22 см/с</span>
                                    <span class="calculator__result-tabs-col-item">5500 мм</span>
                                    <span class="calculator__result-tabs-col-item">13,75 м³</span>
                                    <span class="calculator__result-item-description">
                                        {{ dr.description || 'Запрос положения; быстрое открывание двери; дополнительная. высота открывания; отдельно включ. галогенное освещ.; отдельно включ. светодиодное освещение (с марта 2017); простое программирование; защита от подваживания; система ДУ BiSecure' }}
                                    </span>
                                    </div>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class="calculator__result-tabs-content-item d-f" v-if="driveTab === 'hand'">
                            <label>
                                <div class="calculator__result-item-name">Здесь пока нет информации</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `,
    data() {
        return {
            driveId: null,
            selectedDrive: '',
            driveTab: 'auto'
        }
    },
    props: {
        driveData: {
            type: Array,
            default() {
                return []
            }
        },
    },
    methods: {
        selected(id) {
            if (id == 5) {
                this.selectedDrive = 'Без привода';
            } else {
                this.selectedDrive = this.driveData.find(el => el.id === id).name;
            }
                this.$emit('recalculate', { 'name': 'drive', 'selected': id })

        }
    }
});

export default Driveas;