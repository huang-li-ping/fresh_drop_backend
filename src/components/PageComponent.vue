<template>
    <nav style="padding: 15px" v-show="pageTotal !== 1">
        <ul class="pagination">
            <li class="page-item" @click="pagePrev" :class="{disabled:nowPage == 1}">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item" v-for="n in pageTotal" :key="n" :class="{active:nowPage==n}" @click="nowPage = n"><a class="page-link" href="#">{{ n }}</a></li>
            <li class="page-item" @click="pageNext" :class="{disabled:nowPage == pageTotal}">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>
<script>
export default {
    name: "PageComponent",
    props: {
        data: Array,
        dataAmount: {
            type: Number,
            default: 10,
        },
    },
    data() {
        return {
            pageTotal: 1,
            showData: [],
            nowPage: 1,
        };
    },
    methods: {
        calcPageTotal() {
            let Len = this.data.length
            if (Len <= this.dataAmount) {
                this.pageTotal = 1
                return
            }
            this.pageTotal = Math.floor(Len / this.dataAmount)
            let remainDataLen = Len % this.dataAmount
            if (remainDataLen > 0) {
                this.pageTotal += 1
            }
        },
        pageNext() {
            if (this.nowPage == this.pageTotal) {
                console.log('return');
                return
            }
            this.nowPage += 1
            console.log( this.nowPage);
        },
        pagePrev() {
            if (this.nowPage == 1) {
                console.log('return');
                return
            }
            this.nowPage -= 1
            console.log( this.nowPage);
        },
        showPageData() {
            if (this.pageTotal == 1) {
                this.showData = this.data
            } else {
                this.showData = []
                let dateStart = (this.nowPage - 1) * this.dataAmount
                let dataEnd = this.dataAmount * this.nowPage - 1
                if (dataEnd > this.data.length - 1) {
                    dataEnd = this.data.length - 1
                }
                for (let i = dateStart; i <= dataEnd; i++) {
                    this.showData.push(this.data[i])
                    
                }
            }
            this.$emit('changePage', this.showData)
        },
    },
    watch: {
        nowPage() {
            this.showPageData()
        },
        data() {
            this.calcPageTotal()
            this.showPageData()
        }
    },
    mounted() {
        this.calcPageTotal()
        this.showPageData()
    },
};
</script>
<style lang="scss">
.pagination {
    justify-content: center;
}
</style>
