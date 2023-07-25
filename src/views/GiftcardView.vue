<template>
  <div class="container-fluid">

    <nav class="navbar">
      <a href="#">
        <img src="../assets/images/logo/logo.png" alt="logo">
      </a>
      <span>後台管理</span>
      <button class="btn btn-outline-light" type="button">登出</button>
    </nav>
    <div class="row">
      <div class="sidebar">
        <ul>

          <router-link v-for="(item, index) in list" :key="index" :to="item.href" class="item">
            {{ item.title }}
          </router-link>
        </ul>
      </div>


      <div class="main">

        <h5>禮物卡管理 / 樣式</h5>
        <hr>
        <div class="container">
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="搜尋樣式">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button">search</button>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="input-group-append">
                  <button class="btn btn-primary" type="button">新增樣式</button>
                </div>
            </div>

            
          </div>
        </div>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Larry</td>
              <td>the Bird</td>
              <td>@twitter</td>
            </tr>
          </tbody>
        </table>


        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>

      </div>
    </div>
  </div>
</template>
<script>

export default {
  data() {
    return {
      list: [{
        href: '#',
        title: '訂單管理',
      },
      {
        href: '#',
        title: '會員資料管理',
      },
      {
        href: '#',
        title: '菜色',
      },
      {
        href: '#',
        title: '食材',
      },
      {
        href: '#',
        title: '禮物卡管理',
      },
      {
        href: '#',
        title: '烹飪心得管理',
      },
      {
        href: '#',
        title: 'FAQ管理',
      },
      {
        href: '#',
        title: '遊戲結果管理',
      },
      {
        href: '#',
        title: '管理員帳號管理',
      },
      ]
    }
  },

  methods: {}
};

</script>

<style lang="scss">
@import '../assets/scss/all.scss';
@import 'bootstrap/dist/css/bootstrap.min.css';
// @import '../assets/scss/page/giftcard.scss';
</style>