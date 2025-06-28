<form class="form form-no-bg" name="<?= $arResult["arForm"]['VARNAME'] ?>" action="<?= POST_FORM_ACTION_URI ?>"
      enctype="multipart/form-data" method="post" data-app="form">
    <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult["arForm"]['ID'] ?>">
    <?= bitrix_sessid_post() ?>
    <div class="title-row">
        <h1 class="h2">Рассчитать стоимость</h1>
        <div class="select" data-app="select">
            <select name="form_<?= $arResult["QUESTIONS"]["CALCULATE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["CALCULATE"]["STRUCTURE"][0]["ID"] ?>">
                <option value="Гаражный ворот">Гаражный ворот</option>
                <option value="Гаражных дверей">Гаражных дверей</option>
                <option value="Входных дверей">Входных дверей</option>
                <option value="Межкомнатных дверей">Межкомнатных дверей</option>
            </select>
        </div>
    </div>
    <div class="form__box margin-72">
        <div class="title-text">О проекте</div>
        <div class="form__input">
            <div class="form__label">Для какого объекта нужны ворота?</div>
            <div class="select" data-app="select">
                <select name="form_<?= $arResult["QUESTIONS"]["OBJECT"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["OBJECT"]["STRUCTURE"][0]["ID"] ?>">
                    <option value="Частный гараж">Частный гараж</option>
                    <option value="Парковка">Парковка</option>
                    <option value="Промышленное здание">Промышленное здание</option>
                    <option value="Другое">Другое</option>
                </select>
            </div>
        </div>
        <div class="form__input">
            <div class="form__label">Расскажите о вашем объекте, опишите задачу. Какие особенности?</div>
            <div class="form__field">
                <textarea
                        name="form_<?= $arResult["QUESTIONS"]["MESSAGE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["MESSAGE"]["STRUCTURE"][0]["ID"] ?>"></textarea>
            </div>
            <div class="form__file">
                <label>
                    <input type="file"
                           name="form_<?= $arResult["QUESTIONS"]["FILE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["FILE"]["STRUCTURE"][0]["ID"] ?>"
                           multiple>
                    <div class="form__file__title" data-text="Файл не выбран" data-multiple="Выбрано файлов:">Приложите
                        файл
                    </div>
                    <div class="form__file__text">Схемы, описания, изображения объекта</div>
                </label>
            </div>
        </div>
    </div>
    <div class="title-text">Параметры ворот</div>
    <div class="form-image margin-72">
        <div class="form-image__left">
            <div class="form__row">
                <div class="form__col">
                    <div class="form__input">
                        <div class="form__label">Количество дверей</div>
                        <div class="form__field">
                            <input type="text"
                                   name="form_<?= $arResult["QUESTIONS"]["DOOR"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["DOOR"]["STRUCTURE"][0]["ID"] ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__row">
                <div class="form__col">
                    <div class="form__input">
                        <div class="form__label">Ширина ворот – A</div>
                        <div class="form__field">
                            <input type="text"
                                   name="form_<?= $arResult["QUESTIONS"]["FIELD_A"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["FIELD_A"]["STRUCTURE"][0]["ID"] ?>">
                            <div class="form__field__sm">см</div>
                        </div>
                    </div>
                </div>
                <div class="form__col">
                    <div class="form__input">
                        <div class="form__label">Высота ворот – B</div>
                        <div class="form__field">
                            <input type="text"
                                   name="form_<?= $arResult["QUESTIONS"]["FIELD_B"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["FIELD_B"]["STRUCTURE"][0]["ID"] ?>">
                            <div class="form__field__sm">см</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-image__right"><img src="/static/build/images/temp/93.jpg" alt=""></div>
    </div>
    <div class="form__box">
        <div class="title-text">Контактные данные</div>
        <div class="form__radio">
            <label>
                <input type="radio"
                       name="form_<?= $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["ID"] ?>"
                       value="Частное лицо"><i></i><span>Частное лицо</span>
            </label>
            <label>
                <input type="radio"
                       name="form_<?= $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["ID"] ?>"
                       value="Архитектор"><i></i><span>Архитектор</span>
            </label>
            <label>
                <input type="radio"
                       name="form_<?= $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["ID"] ?>"
                       value="Заказчик"><i></i><span>Заказчик</span>
            </label>
            <label>
                <input type="radio"
                       name="form_<?= $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["ID"] ?>"
                       value="Строительная организация" checked><i></i><span>Строительная организация</span>
            </label>
            <label>
                <input type="radio"
                       name="form_<?= $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PERSON_TYPE"]["STRUCTURE"][0]["ID"] ?>"
                       value="Другое"><i></i><span>Другое</span>
            </label>
        </div>
        <div class="form__row form__row_width-50">
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Ваше имя</div>
                    <div class="form__field">
                        <input type="text"
                               name="form_<?= $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["NAME"]["STRUCTURE"][0]["ID"] ?>"
                               data-validation="{&quot;regex&quot;:[&quot;^[a-zA-Zа-яА-Я\\s]+$&quot;,&quot;ig&quot;],&quot;maxlength&quot;:300}"
                               required>
                    </div>
                </div>
            </div>
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Город</div>
                    <div class="form__field">
                        <input type="text"
                               name="form_<?= $arResult["QUESTIONS"]["CITY"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["CITY"]["STRUCTURE"][0]["ID"] ?>"
                               data-validation="{&quot;regex&quot;:[&quot;^[a-zA-Zа-яА-Я\\s]+$&quot;,&quot;ig&quot;],&quot;maxlength&quot;:300}"
                               required>
                    </div>
                </div>
            </div>
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Телефон</div>
                    <div class="form__field">
                        <input type="tel" placeholder="+7 (___) ___ __-__" data-app="mask"
                               data-mask="+7 (999) 999 99-99" inputmode="text"
                               name="form_<?= $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["PHONE"]["STRUCTURE"][0]["ID"] ?>"
                               required>
                    </div>
                </div>
            </div>
            <div class="form__col">
                <div class="form__input">
                    <div class="form__label">Email</div>
                    <div class="form__field">
                        <input type="email"
                               name="form_<?= $arResult["QUESTIONS"]["EMAIL"]["STRUCTURE"][0]["FIELD_TYPE"] . "_" . $arResult["QUESTIONS"]["EMAIL"]["STRUCTURE"][0]["ID"] ?>"
                               data-validation="{&quot;regex&quot;:[&quot;^\\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,6}\\b$&quot;,&quot;i&quot;],&quot;maxlength&quot;:254}"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6Lc5kI8qAAAAAGY_fMXZuEdoeKsn3PpWk0VlB0oc"></div>
        <div class="form__submit">
            <button class="btn" type="submit"><span>Отправить</span></button>
            <div class="checkbox">
                <label>
                    <input type="checkbox" checked name="checkbox" required><i></i><span>Я ознакомлен и согласен с условиями сбора и обработки персональных данных в рамках <a
                                href="/privacy/">Политики конфиденциальности</a></span>
                </label>
            </div>
        </div>
    </div>
    <input type="hidden" name="web_form_submit" value="Сохранить">
</form>