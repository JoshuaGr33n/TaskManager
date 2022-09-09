      @extends('layout1')
      @section('title', 'Login')
      @section('content')
      <div class="main">
          <!-- Log in  Form -->
          <section class="sign-in">
              <div class="container">
                  <div class="signin-content">
                      <div class="signin-image">
                          <figure><img src="{{ asset('public/assets/images/signin-image.jpg') }}" alt="Login image"></figure>
                          <a href="register" class="signup-image-link">Create an account</a>
                      </div>

                      <div class="signin-form">
                          <h2 class="form-title">Sign up</h2>
                          <div id="app">
                              <p><span v-if="login_err" :class="['label label-danger']">Login Error</span></p>
                              <p><span v-if="status_err" :class="['label label-danger']">Account not yet Activated</span></p>
                              <form method="POST" class="register-form" id="login-form" action="{{url('login')}}" @submit.prevent="onSubmit">
                                  @csrf
                                  <div :class="['form-group', allerros.email ? 'has-error' : '']">
                                      <label for="email"><i class="zmdi zmdi-email"></i></label>
                                      <input type="email" name="email" id="email" placeholder="Your Email*" v-model="form.email" />
                                      <span v-if="allerros.email" :class="['label label-danger']">@{{ allerros.email[0] }}</span>
                                      <div :class="['label label-danger']" v-show="form.email &amp;&amp; !isEmailValid">Invalid Email</div>
                                  </div>
                                  <div :class="['form-group', allerros.password ? 'has-error' : '']">
                                      <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                      <input type="password" name="password" id="password" placeholder="Password*" v-model="form.password" />
                                      <span v-if="allerros.password" :class="['label label-danger']">@{{ allerros.password[0] }}</span>
                                  </div>
                                  <div class="form-group form-button">
                                      <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                                  </div>
                              </form>
                          </div>
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
                      email: '',
                      password: '',
                  },
                  allerros: [],
                  success: false,
                  login_err: false,
                  status_err: false,
              },
              computed: {
                  isEmailValid: function isEmailValid() {
                      return (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.form.email));
                  },
              },
              methods: {
                  onSubmit() {
                      dataform = new FormData();

                      dataform.append('email', this.form.email);
                      dataform.append('password', this.form.password);
                      console.log(this.form.email);

                      axios.post('{{url("login")}}', dataform).then(response => {
                          console.log(response.data.success);
                          console.log(response.status);
                          this.allerros = [];
                          this.success = true
                          if (response.data.feedback === 'Admin') {
                              window.location.href = "admin";
                          }else if (response.data.feedback === 1) {
                              window.location.href = "user";
                          } else if(response.data.feedback === 2){
                              this.status_err = true
                          } else {
                              this.login_err = true
                          }
                      }).catch((error) => {
                          this.allerros = error.response.data.errors;
                          this.success = false;
                      });
                  }
              }
          });
      </script>
      @stop