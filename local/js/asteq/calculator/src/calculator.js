import {Vue} from "ui.vue";
import SimpleVueValidator from "simple-vue-validator";
import MaskedInput from "vue-masked-input";
import "./accordion";
import "./accordionItem";
import "./gateSize";
import "./baseas";
import "./coloras";
import "./surfaceas";
import "./driveas";
import "./faceas";
import "./glassas";

export class Calculator {
    constructor(options = {el: "", params: {}}) {
        this.params = options.params;

        if (options.el) this.vueComponent = this.createVueComponent(options.el);
    }

    createVueComponent(el) {
        const Validator = SimpleVueValidator.Validator;

        this.vueComponent = Vue.create({
            el: el,
            components: {
                MaskedInput
            },
            data() {
                return {
                    sTemplate: null,
                    sParams: null,
                    action: null,
                    loading: false,
                    timer: null,
                    defaultPhoto: '/static/src/images/calculator/templates-1.png',
                    mainImg: "/static/src/images/calculator/templates-1.png",
                    photo: null,

                    surface: [],
                    base: [],
                    sizes: [],
                    def_color: [],
                    rec_colors: [],
                    glass: [],
                    gateTypes: [],
                    facings: [],
                    drive: [],
                    maxWidth: null,
                    maxHeight: null,
                    minWidth: null,
                    minHeight: null,
                    total: null,
                    descriptions: null,

                    name: null,
                    lastName: null,
                    email: null,
                    phone: null,
                    city: null,
                    comment: null,
                    success: false,
                    successMsg: '',

                    submitted: null,

                    selectedPart: "size",
                    visited: [
                        'size'
                    ],
                    isFinal: false,
                    isEnd: false,
                    parts: [
                        {
                            key: "gateSize",
                            value: "Размеры ворот",
                            selected: "",
                            available: false,
                            modal: "gateSizeModalText",
                            internalName: 'size',
                            validateFunction: () => {
                                return (this.selected.width >= this.minWidth && this.selected.width <= this.maxWidth)
                                    && (this.selected.height >= this.minHeight && this.selected.height <= this.maxHeight);
                            },
                            showError: false,
                            errorMessage: 'Введите размеры ворот'
                        },
                        {
                            key: "surface",
                            value: "Поверхность",
                            selected: "",
                            available: false,
                            modal: "surfaceModalText",
                            internalName: 'surface',
                            validateFunction: () => {
                                return this.selected.surface != null && this.selected.surface != undefined;
                            },
                            showError: false,
                            errorMessage: 'Выберите тип поверхности'
                        },
                        {
                            key: "base",
                            value: "Мотив",
                            selected: "",
                            available: false,
                            modal: "baseModalText",
                            internalName: 'base',
                            validateFunction: () => {
                                return this.selected.base != null && this.selected.base != undefined;
                            },
                            showError: false,
                            errorMessage: 'Выберите мотив'
                        },
                        {
                            key: "color",
                            value: "Цвет",
                            selected: "",
                            available: false,
                            modal: "colorModalText",
                            internalName: "color",
                            validateFunction: () => {
                                return this.selected.color != null && this.selected.color != undefined;
                            },
                            showError: false,
                            errorMessage: 'Выберите цвет'
                        },
                        {
                            key: "drive",
                            value: "Управление",
                            selected: "",
                            available: false,
                            modal: "driveModalText",
                            internalName: "drive"
                        },
                        {
                            key: "face",
                            value: "Отделка",
                            selected: "",
                            available: false,
                            modal: "faceModalText",
                            internalName: "facing",
                            /* validateFunction: () => {
                                return this.selected.face != null && this.selected.face != undefined;
                            }, */
                            showError: false,
                            errorMessage: 'Выберите дизайн'
                        },
                        {
                            key: "glass",
                            value: "Остекление",
                            selected: "",
                            available: false,
                            modal: "glassModalText",
                            internalName: "glass",
                            /* validateFunction: () => {
                                return this.selected.glass != null && this.selected.glass != undefined;
                            }, */
                            showError: false,
                            errorMessage: 'Выберите тип остекления'
                        },
                    ],
                    activePart: "",
                    currentModalText: "",
                    driveTab: "auto",

                    selected: {
                        gateType: 1,
                        surface: null,
                        base: null,
                        face: null,
                        drive: 5,
                        color: null,
                        glass: null,
                        width: null,
                        height: null,
                        size: null,
                    },
                };
            },
            props: [],
            computed: {
                selectedGateTypeName() {
                    if (this.selected.gateType) {
                        for (const gateType of this.gateTypes) {
                            if (gateType.ID == this.selected.gateType) {
                                return gateType.UF_NAME;
                            }
                        }
                    }

                    return "";
                },
                error() {
                    if (this.selected && this.selected.base && this.selected.face) {
                        for (const baseElement of this.base) {
                            if (baseElement.id == this.selected.base && baseElement.available === false) {
                                return "Недоступно с выбранными параметрами"
                            }
                        }
                    }

                    return "";
                },
                error2() {
                    if (this.selected && this.selected.surface && this.selected.face) {
                        for (const baseElement of this.surface) {
                            if (baseElement.id == this.selected.surface && baseElement.available === false) {
                                return "Недоступно с выбранными параметрами"
                            }
                        }
                    }

                    return "";
                },
            },
            watch: {
                "selected.gateType"(newValue, oldValue) {
                    if (newValue != null) {
                        this.getAvailableParams(newValue);
                    }
                },
                "selected.width"(newValue, oldValue) {
                    if (newValue != oldValue && newValue != null) {
                        this.getDrives();
                    }
                },
                "selected.height"(newValue, oldValue) {
                    if (newValue != oldValue && newValue != null) {
                        this.getDrives();
                    }
                },
            },
            methods: {
                isPartClickable(partName) {
                    return this.visited.includes(partName)
                },
                onPartSelect(arg) {
                    this.setSelectedPart(arg['name']);
                },
                onGoNext(arg) {
                    let next = this.getNextPartName(arg['name']);

                    if (next) {

                        this.isFinal = false;
                        const currentPart = this.getCurrentPart();

                        if (currentPart.validateFunction != null && currentPart.validateFunction != undefined) {
                            if (currentPart.validateFunction()) {
                                currentPart.showError = false;
                                this.visited.push(next);
                                this.setSelectedPart(next);
                            } else {
                                currentPart.showError = true;
                            }
                        } else {
                            this.visited.push(next);
                            this.setSelectedPart(next);
                            currentPart.showError = false;
                        }

                    } else {
                        this.isFinal = true;
                        this.isEnd = true;
                    }
                },
                setSelectedPart(partName) {
                    this.selectedPart = partName;
                },
                getNextPartName(partName) {
                    let partNameIndex = -1;
                    for (let i = 0; i < this.parts.length; i++) {
                        if (this.parts[i].internalName === partName) {
                            partNameIndex = i;
                        }
                    }

                    if (partNameIndex === this.parts.length - 1) {
                       return null;
                    } else {
                        let before = partNameIndex;
                        for (let i = partNameIndex + 1; i < this.parts.length; i++) {
                            let partInternalName = this.parts[i].internalName;
                            let name = '';

                            switch (partInternalName) {
                                case 'surface':
                                    name = 'surface';
                                    break;
                                case 'base':
                                    name = 'base';
                                    break;
                                case 'color':
                                    name = 'rec_colors';
                                    break;
                                case 'drive':
                                    name = 'drive';
                                    break;
                                case 'facing':
                                    name = 'facings';
                                    break;
                                case 'glass':
                                    name = 'glass';
                                    break;
                            }

                            if (name && this.isPartAvailable(name)) {
                                partNameIndex = i;
                                break;
                            }
                        }

                        if (before === partNameIndex) {
                            partNameIndex = 0;

                            return null;
                        }
                    }

                    return this.parts[partNameIndex].internalName;
                },
                getCurrentPart() {
                    for (const part of this.parts) {
                        if (part.internalName == this.selectedPart) {
                            return part;
                        }
                    }
                    return null;
                },
                setCurrentModalText(e) {
                    console.log(e);
                    const part = e.target.getAttribute("data-part");
                    const partElement = this.parts.filter((el) => {
                        return el.key === part;
                    });
                    if (this.descriptions && this.descriptions[part]) {
                        this.currentModalText = this.descriptions[part];
                        $.fancybox.open(e.target);
                    }
                },
                isPartAvailable(partName) {
                    for (const item of this[partName]) {

                        if (partName != 'drive') {
                            if (item.available === null || item.available === undefined) {
                                return true;
                            }
                        }

                        if (item.available === true && item.id) {
                            return true;
                        }
                    }

                    return false;
                },
                setAjaxParams(params) {
                    this.sTemplate = params.sTemplate;
                    this.sParams = params.sParams;
                    this.action = params.action;
                },
                setData(params) {
                    if (params.gateTypes) {
                        this.gateTypes = params.gateTypes;
                    }

                    if (params.type) {
                        this.selected.gateType = params.type;
                    }

                    if (params.descriptions) {
                        this.descriptions = params.descriptions;
                    }

                    if (params.city) {
                        this.city = params.city;
                    }
                },
                getSelectedValue(name) {
                    let id = this.selected[name];

                    if (name === "color") {
                        id = this.selected[name];
                        name = "rec_colors";
                    }

                    if (name === "face") {
                        name = "facings";
                    }

                    if (name === "size") {
                        this.parts[0].selected = `${this.selected.width} x ${this.selected.height}`;
                        return;
                    }

                    if (name === "drive" && this.selected.drive == 5) {
                        const obj = this.parts.find((el) => el.key === 'drive');
                        obj.selected = 'Без привода';

                        return;
                    }

                    let arr = this[name];
                    const value = arr.find((el) => el.id === id).name;
                    const obj = this.parts.find(
                        (el) =>
                            el.key ===
                            (name === "rec_colors"
                                ? "color"
                                : name === "facings"
                                    ? "face"
                                    : name)
                    );

                    obj.selected = value || "";
                },
                recalculate(name) {
                    this.getSelectedValue(name);

                    const data = this.selected;
                    data["action"] = "recalculate";

                    // Если заполнены параметры по которым идет расчет цены
                    // то рапрашиваем цены
                    if (
                        this.selected.base &&
                        this.selected.surface &&
                        this.selected.width &&
                        this.selected.height
                    ) {
                        data["showPrice"] = true;
                    }

                    this.sendRequest(this.selected);
                },
                getAvailableParams(gateType) {
                    const data = {
                        gateType: gateType,
                        action: "init",
                    };
                    this.sendRequest(data);

                    this.selected = {
                        gateType: gateType,
                        surface: null,
                        base: null,
                        face: null,
                        drive: 5,
                        color: null,
                        glass: null,
                        width: null,
                        height: null,
                        size: null,
                    };

                    for (let i = 0; i < this.parts.length; i++) {
                        //this.parts[i].available = false;
                        this.parts[i].selected = null;
                    }

                    this.selectedPart = 'size';
                    this.visited = ['size'];
                    this.isEnd = false;
                },
                getDrives() {
                    this.$validate().then((success) => {
                        if (success) {
                            if (this.selected.width && this.selected.height && !this.timer) {
                                this.timer = setTimeout(() => {
                                    this.recalculate("size");
                                    this.timer = null;
                                }, 500);
                            }
                        } else {
                            this.drive = [];
                            this.parts[4].available = false;
                        }
                    });
                },
                createOrder() {
                    const data = this.selected;
                    data["action"] = "createOrder";
                    this.submitted = true;

                    this.$validate().then((success) => {
                        data['name'] = this.name;
                        data['lastName'] = this.lastName;
                        data['comment'] = this.comment;
                        data['phone'] = this.phone;
                        data['email'] = this.email;
                        data['city'] = this.city;

                        if (success) {
                            this.sendRequest(data);
                        }
                    });
                },
                checkPartAvailable(part) {
                    for (let i = 0; i < part.length; i++) {
                        // available может быть равно undefined в том случае, если это первый и единственный выбранный параметр
                        if (
                            part[i]["available"] === true ||
                            part[i]["available"] === undefined
                        ) {
                            return true;
                        }
                    }
                    return false;
                },
                sendRequest(data) {
                    data["template"] = this.sTemplate;
                    data["parameters"] = this.sParams;

                    BX.ajax({
                        method: "POST",
                        dataType: "json",
                        url: this.action,
                        data: data,
                        onsuccess: (response) => {
                            if (response.status && response.msg) {
                                this.success = true;
                                this.successMsg = response.msg;
                                return;
                            } else {

                                this.success = false;
                                this.successMsg = '';

                                if (response.photo) {
                                    this.mainImg = response.photo;
                                    this.photo = response.photo;
                                } else {
                                    this.mainImg = this.defaultPhoto;
                                    this.photo = this.defaultPhoto;
                                }

                                this.parts[0].available =
                                    response["maxHeight"] && response["maxWidth"];
                                this.parts[1].available = response["surface"].length
                                    ? this.checkPartAvailable(response["surface"])
                                    : false;
                                this.parts[2].available = response["base"].length
                                    ? this.checkPartAvailable(response["base"])
                                    : false;
                                this.parts[3].available = response["rec_colors"].length
                                    ? this.checkPartAvailable(response["rec_colors"])
                                    : false;
                                this.parts[4].available = response["drive"].length
                                    ? this.checkPartAvailable(response["drive"])
                                    : false;
                                this.parts[5].available = response["facings"].length
                                    ? this.checkPartAvailable(response["facings"])
                                    : false;
                                this.parts[6].available = response["glass"].length
                                    ? this.checkPartAvailable(response["glass"])
                                    : false;
                                for (const responseKey in response) {
                                    if (!response.hasOwnProperty(responseKey)) {
                                        continue;
                                    }
                                    if (this.hasOwnProperty(responseKey)) {
                                        this[responseKey] = response[responseKey];
                                    }
                                }
                                if (this.maxWidth && this.maxHeight) {
                                    const widthParams = {min: this.minWidth, max: this.maxWidth};
                                    const heightParams = {
                                        min: this.minHeight,
                                        max: this.maxHeight,
                                    };
                                    const valids = this.getSizeValidators(
                                        widthParams,
                                        heightParams
                                    );
                                    this.$setValidators(valids);
                                }

                                this.sizes = response.sizes;
                                BX.UI.Hint.init(BX('calculator-container'));

                            }

                            if (response.status && response.msg) {

                            }
                        },
                    });
                },

                getSizeValidators(width, height) {
                    return {
                        "selected.width": function (value) {
                            return Validator.value(value)
                                .digit("Допустим ввод только цифр")
                                .between(
                                    width.min,
                                    width.max,
                                    `Допустимо от ${width.min} до ${width.max}`
                                );
                        },
                        "selected.height": function (value) {
                            return Validator.value(value)
                                .digit("Допустим ввод только цифр")
                                .between(
                                    height.min,
                                    height.max,
                                    `Допустимо от ${height.min} до ${height.max}`
                                );
                        }
                    };
                },
                getPersonalValidators() {
                    return {
                        'phone': function (value) {
                            if (this.submitted) {
                                return Validator.value(value).required('Поле обязательно для заполнения').regex(/\+7\s\(\d{3}\)\s\d{3}\s\d{2}-\d{2}/, 'Некорректный номер телефона');
                            }
                        },
                        'email': function (value) {
                            if (this.submitted) {
                                return Validator.value(value).required('Поле обязательно для заполнения').email('Не корректный e-mail');
                            }
                        },
                        'name': function (value) {
                            if (this.submitted) {
                                return Validator.value(value).required('Поле обязательно для заполнения');
                            }
                        },
                        'lastName': function (value) {
                            if (this.submitted) {
                                return Validator.value(value).required('Поле обязательно для заполнения');
                            }
                        },
                        'city': function (value) {
                            if (this.submitted) {
                                return Validator.value(value).required('Поле обязательно для заполнения');
                            }
                        },
                    }
                },
                setSize(payload) {
                    this.selected[payload.type] = +payload.value;
                },
                userSelected(payload) {
                    console.log(payload);
                    this.selected[payload.name] = payload.selected;
                    this.recalculate(payload.name);

                    /* if (this.photo) {
                        this.mainImg = this.photo;
                    } else {
                        if (payload.name === "surface" || payload.name === "base") {
                            const selectedId = +payload.selected;

                            for (const item of this[payload.name]) {
                                if (item.id == selectedId && item.img) {
                                    this.mainImg = item.img;
                                }
                            }
                        }
                    }

                    if (!this.mainImg) {
                        this.mainImg = this.defaultPhoto;
                    } */
                },
                test() {
                    const validators = this.getPersonalValidators();
                    this.$setValidators(validators);
                }
            },
            mixins: [SimpleVueValidator.mixin],
            validators: {},
        });

        this.vueComponent.setData(this.params);
        this.vueComponent.setAjaxParams(this.params);

        return this.vueComponent;
    }
}
