<template>
    <div class="container">
        <div class="nav-avoid">
            <h1>Enero 2021</h1>
            <ol class="booking-ol">
                <li class="day-name">Lun</li>
                <li class="day-name">Mar</li>
                <li class="day-name">Mié</li>
                <li class="day-name">Jue</li>
                <li class="day-name">Vie</li>
                <li class="day-name">Sáb</li>
                <li class="day-name">Dom</li>

                <li class="first-day">1</li>
                <li>2</li>
                <li>3</li>
                <li>4</li>
                <li>5</li>
                <li>6</li>
                <li>7</li>
                <li>8</li>
                <li>9</li>
                <li>10</li>
                <li>11</li>
                <li>12</li>
                <li>13</li>
                <li>14</li>
                <li>15</li>
                <li>16</li>
                <li>17</li>
                <li>18</li>
                <li>19</li>
                <li>20</li>
                <li>21</li>
                <li>22</li>
                <li>23</li>
                <li>24</li>
                <li>25</li>
                <li>26</li>
                <li>27</li>
                <li>28</li>
                <li>29</li>
                <li>30</li>
                <li>31</li>
            </ol>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted} from 'vue'

const posts = ref();

function getImageUrl(post) {
    let image
    if (post.resized_image.length > 0) {
        image = post.resized_image
    } else {
        image = post.original_image
    }
    return new URL(image, import.meta.url).href
}

onMounted(() => {
    axios.get('/api/get-posts').then(({data}) => {
        posts.value = data;
    })
})
</script>
