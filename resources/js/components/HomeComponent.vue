<template>
    <div class="container form-group mt-5">
        <v-app id="inspire">
            <notifications group="noty"/>
            <div class="d-flex flex-column justify-content-center w-50 m-auto p-4 border">
                <div class="text-center">TEST FORM</div>
                <input v-mask="'8##########'" class="form-control mt-1 mb-1" v-model="phone"
                       placeholder="введите номер телефона..."/>
                <input class="form-control mt-1 mb-1" v-model="name" placeholder="введите имя..."/>
                <input class="form-control mt-1 mb-1" v-model="deliveryAddress"
                       placeholder="введите адрес доставки..."/>
                <select
                    class="mt-1 mb-1 form-control"
                    v-model="selectedTariff">
                    <option :value="null" disabled>выберите тариф...</option>
                    <option v-for="(tariff) in tariffList" :value="tariff"> {{ tariff.name }} ({{ tariff.price }})
                    </option>
                </select>
                <div style="margin-left: -30px">
                    <v-menu
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="selectedDate"
                                label="Picker without buttons"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            :allowed-dates="allowedDates"
                            v-model="selectedDate"
                            @input="menu = false"
                        ></v-date-picker>
                    </v-menu>
                    <v-spacer></v-spacer>
                </div>
                <button @click="createOrder" :disabled="isSendBtnDisabled" class="btn btn-primary" type="submit">
                    Отправить
                </button>
            </div>
        </v-app>
    </div>
</template>

<script>
const PHONE_NUMBER_LENGTH = 11;
export default {
    data: () => ({
        phone: '',
        name: '',
        deliveryAddress: '',
        selectedDate: '',
        selectedTariff: null,
        menu: false,
        isSendBtnDisabled: false,
        tariffList: [],
        errors: []
    }),
    mounted() {
        this.getTariffList()
    },
    methods: {
        allowedDates(val) {
            return this.selectedTariff.dates.includes(val);
        },
        createOrder() {
            if (!this.checkFormValidation()) {
                return;
            }
            this.isSendBtnDisabled = true

            axios.post('/api/order',
                {
                    name: this.name,
                    phone: this.phone,
                    tariffId: this.selectedTariff.id ?? 1,
                    deliveryAddress: this.deliveryAddress,
                    date: this.selectedDate,
                })
                .then(response => {
                    if (response.data.success !== 1) {
                        this.errors = Object.values(response.data.errors)
                        this.notifyAboutErrors();

                        return;
                    }

                    this.$notify({
                        group: 'noty',
                        title: 'Уведомление',
                        type: 'success',
                        text: 'Заказ успешно создан'
                    });
                })
                .catch(() => {
                    this.$notify({
                        group: 'noty',
                        title: 'Уведомление',
                        type: 'warn',
                        text: 'Что-то пошло не так'
                    });
                })
                .finally(() => {
                  this.isSendBtnDisabled = false
                })
        },
        getTariffList() {
            axios.get('/api/tariffs')
                .then(response => {
                    this.tariffList = response.data
                    this.selectedTariff = this.tariffList[0]
                })
                .catch(e => {
                    this.errors.push(e)
                })
        },
        checkFormValidation() {
            return true;
            if (this.phone.length !== PHONE_NUMBER_LENGTH) {
                this.errors.push('Номер должен содержать 11 символов');
            }

            if (this.name.length === 0) {
                this.errors.push('Введите пожалуйста имя');
            }

            if (this.deliveryAddress.length === 0) {
                this.errors.push('Введите пожалуйста адрес доставки');
            }

            if (this.selectedDate.length === 0) {
                this.errors.push('Выберите доступную дату доставки');
            }

            if (this.errors.length !== 0) {
                this.notifyAboutErrors();

                return false;
            }

            return true;
        },
        notifyAboutErrors() {
            this.errors.forEach(e => {
                this.$notify({
                    group: 'noty',
                    title: 'Ошибка заполнения',
                    type: 'warn',
                    text: e
                });
            })

            this.clearErrorsList();
        },
        clearErrorsList() {
            this.errors = [];
        }
    }
}
</script>
