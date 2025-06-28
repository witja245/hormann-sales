<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="hidden">
    <div class="modal modal-type" id="modal-type" v-html="currentModalText">
    </div>

    <form class="modal modal-order" method="post" id="modal-order" @submit.prevent="createOrder">
        <div class="modal-order-success">
            <div class="h2" v-if="success">Спасибо!</div>
            <div class="form form-no-bg" v-if="success" v-html="successMsg">
            </div>
        </div>
        <div class="form-inner">
            <div class="form-inner-right">
                <div class="h2" v-if="!success" >Заказать</div>
                <div class="form form-no-bg" v-if="!success">
                    <div class="form__input">
                        <div class="form__label">Имя</div>
                        <div class="form__field">
                            <input type="text" v-model="name" :class="{'error': validation.hasError('name')}">
                            <label class="error" v-if="validation.hasError('name')">{{validation.firstError('name')}}</label>
                        </div>
                    </div>
                    <div class="form__input">
                        <div class="form__label">Фамилия</div>
                        <div class="form__field">
                            <input type="text" v-model="lastName"
                                   :class="{'error': validation.hasError('lastName')}">
                            <label class="error" v-if="validation.hasError('name')">{{validation.firstError('lastName')}}</label>
                        </div>
                    </div>
                    <div class="form__input">
                        <div class="form__label">Город</div>
                        <div class="form__field">
                            <input type="text" v-model="city" :class="{'error': validation.hasError('city')}">
                            <label class="error" v-if="validation.hasError('city')">{{validation.firstError('city')}}</label>
                        </div>
                    </div>
                    <div class="form__input">
                        <div class="form__label">Телефон</div>
                        <div class="form__field">
                            <input type="tel" placeholder="+7 (___) ___ __-__"
                                   data-app="mask"
                                   data-mask="+7 (999) 999 99-99"
                                   onchange="calculator.vueComponent._data.phone = this.value"
                                   inputmode="text"
                                   v-model="phone"
                                   :class="{'error': validation.hasError('phone')}">

                            <label class="error" v-if="validation.hasError('phone')">{{validation.firstError('phone')}}</label>
                        </div>
                    </div>
                    <div class="form__input">
                        <div class="form__label">Email</div>
                        <div class="form__field">
                            <input type="email" placeholder="example@example.com" v-model="email"
                                   :class="{'error': validation.hasError('email')}">
                            <label class="error" v-if="validation.hasError('email')">{{validation.firstError('email')}}</label>
                        </div>
                    </div>
                    <div class="form__input">
                        <div class="form__label">Комментарий</div>
                        <div class="form__field">
                            <textarea v-model="comment" maxlength="300"></textarea>
                        </div>
                    </div>
                    <div class="form__submit">
                        <button class="btn" type="submit"><span>Отправить</span></button>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="checkbox" required><i></i><span>Я ознакомлен и согласен с условиями сбора и обработки персональных данных в рамках <a
                                        href="/privacy/">Политики конфиденциальности</a></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-inner-left" v-if="!success">
                <div class="h2">
                    {{ selectedGateTypeName }}
                </div>
                <div class="calculator__result-img">
                    <img :src="mainImg"/>
                </div>
                <div class="calculator__result-selected">
                    <div class="form-result-string" v-if="parts[0].selected">
                        <span class="as-accordion__item-title">Размеры ворот: </span>
                        <span class="accordion__row-result">{{ parts[0].selected }}</span>
                    </div>
                    <div class="form-result-string" v-if="parts[1].selected">
                        <span class="as-accordion__item-title">Поверхность: </span>
                        <span class="accordion__row-result">{{ parts[1].selected }}</span>
                    </div>
                    <div class="form-result-string" v-if="parts[2].selected">
                        <span class="as-accordion__item-title">Мотив: </span>
                        <span class="accordion__row-result">{{ parts[2].selected }} </span>
                    </div>
                    <div class="form-result-string" v-if="parts[3].selected">
                        <span class="as-accordion__item-title">Цвет: </span>
                        <span class="accordion__row-result">{{ parts[3].selected }} </span>
                    </div>
                    <div class="form-result-string" v-if="parts[4].selected">
                        <span class="as-accordion__item-title">Управление: </span>
                        <span class="accordion__row-result">{{ parts[4].selected }} </span>
                    </div>
                    <div class="form-result-string" v-if="parts[5].selected">
                        <span class="as-accordion__item-title">Отделка: </span>
                        <span class="accordion__row-result">{{ parts[5].selected }} </span>
                    </div>
                    <div class="form-result-string" v-if="parts[6].selected">
                        <span class="as-accordion__item-title">Остекление: </span>
                        <span class="accordion__row-result">{{ parts[6].selected }} </span>
                    </div>
                    <div class="form-result-string" v-if="total">
                        <span class="as-accordion__item-title">Цена: </span>
<!--                        <span class="accordion__row-result"-->
<!--                              v-if="total.price > 0">{{total.formattedPrice}}</span>-->
                        <span class="accordion__row-result" >Уточняйте у менеджера</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
