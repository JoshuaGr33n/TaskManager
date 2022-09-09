@extends('layout1')
@section('title', 'Create Account')
@section('content')
<div class="main">
    <!-- Sign up form -->
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Sign up</h2>
                    <div id="app">
                        <span>Required Fields*</span>
                        <form method="POST" class="register-form" id="register-form" action="register" @submit.prevent="onSubmit">
                            {{ csrf_field() }}
                            <div :class="['form-group', allerros.name ? 'has-error' : '']">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name*" v-model="form.name" />
                                <span v-if="allerros.name" :class="['label label-danger']">@{{ allerros.name[0] }}</span>
                            </div>
                            <div :class="['form-group', allerros.phone ? 'has-error' : '']">
                                <label for="phone"><i class="zmdi zmdi-phone"></i></label>
                                <input type="tel" name="phone" id="phone" placeholder="Your Phone Number*" v-model="form.phone" />
                                <span v-if="allerros.phone" :class="['label label-danger']">@{{ allerros.phone[0] }}</span>
                            </div>
                            <div :class="['form-group', allerros.email ? 'has-error' : '']">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email*" v-model="form.email" />
                                <span v-if="allerros.email" :class="['label label-danger']">@{{ allerros.email[0] }}</span>
                                <div :class="['label label-danger']" v-show="form.email &amp;&amp; !isEmailValid">Invalid Email</div>
                            </div>
                            <div :class="['form-group', allerros.repeat_email ? 'has-error' : '']">
                                <label for="repeat-email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="repeat_email" id="repeat-email" placeholder="Repeat Your Email*" v-model="form.repeat_email" />
                                <span v-if="allerros.repeat_email" :class="['label label-danger']">@{{ allerros.repeat_email[0] }}</span>
                            </div>
                            <div :class="['form-group', allerros.password ? 'has-error' : '']">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password*" v-model="form.password" />
                                <span v-if="allerros.password" :class="['label label-danger']">@{{ allerros.password[0] }}</span>
                            </div>
                            <div :class="['form-group', allerros.repeat_password ? 'has-error' : '']">
                                <label for="repeat-password"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="repeat_password" id="repeat-password" placeholder="Repeat your password*" v-model="form.repeat_password" />
                                <span v-if="allerros.repeat_password" :class="['label label-danger']">@{{ allerros.repeat_password[0] }}</span>

                            </div>
                            <div :class="['form-group', allerros.agree_term ? 'has-error' : '']">
                                <input type="radio" name="agree_term" id="agree-term" class="agree-term" v-model="form.agree_term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree to all statements in the <a href="#" class="term-service">Terms of service</a></label>
                                <span v-if="allerros.agree_term" :class="['label label-danger']">@{{ allerros.agree_term[0] }}</span>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                                <span v-if="success" :class="['label label-success']">Registration Successful! Your record have been sent to the admin for approval</span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="signup-image">
                    <figure><img src="{{ asset('public/assets/images/signup-image.jpg') }}" alt="login  image"></figure>
                    <a href="{{url('/')}}" class="signup-image-link">Login</a>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    const app = new Vue({
        el: '#app',

        data: {
            form: {
                name: '',
                phone: '',
                email: '',
                repeat_email: '',
                password: '',
                repeat_password: '',
                agree_term: '',
            },
            allerros: [],
            success: false,
        },
        computed: {
            isEmailValid: function isEmailValid() {
                return (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.form.email));
            },
        },
        methods: {
            onSubmit() {
                dataform = new FormData();
                dataform.append('name', this.form.name);
                dataform.append('phone', this.form.phone);
                dataform.append('email', this.form.email);
                dataform.append('repeat_email', this.form.repeat_email);
                dataform.append('password', this.form.password);
                dataform.append('repeat_password', this.form.repeat_password);
                dataform.append('agree_term', this.form.agree_term);
                console.log(this.form.phone);

                axios.post('register', dataform).then(response => {
                    console.log(response);
                    this.allerros = [];
                    this.form.name = '';
                    this.form.phone = '';
                    this.form.email = '';
                    this.form.repeat_email = '';
                    this.form.password = '';
                    this.form.repeat_password = '';
                    this.form.agree_term = '';
                    this.success = true;
                }).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
                });
            }
        }
    });
</script>
@stop