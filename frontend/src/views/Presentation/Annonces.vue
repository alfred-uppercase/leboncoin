<template>
    <div style="padding-top: 90px;">
      <h1>{{ title }}</h1>
        <div v-for="listing in listings" :key="listing.id">
          <!-- Display other listing details as needed -->
          <div>
    <div
      class="col-lg-6 col-md-6 listing-div "
      :data-marker-id="listing.code"
      :id="listing.code"
    >
      <div
        class="strip grid"
        :class="{ 'featured-tag-border': listing.is_featured === '1' }"
      >
        <figure>
          <a
            href="javascript::"
            class="wishlist-icon"
            @click="addToWishList(listing.id)"
          >
            <i
              :class="{
                'fas fa-heart': isWishlisted(listing.id),
                'far fa-heart': !isWishlisted(listing.id),
              }"
            ></i>
          </a>

          <a
            v-if="listing.is_featured === '1'"
            href="javascript::"
            class="featured-tag-grid"
          >
            {{ get_phrase.featured }}
          </a>

          <a
            :href="getListingUrl(listing.id)"
            :id="'listing-banner-image-for-' + listing.code"
            class="d-block h-100 img"
            :style="{
              'background-image': `url('uploads/listing_thumbnails/${listing.listing_thumbnail}')`,
            }"
          >
            <div class="read_more"><span>{{ get_phrase.watch_details }}</span></div>
          </a>
          <small>
            {{ listing.listing_type === '' ? 'General' : capitalizeFirst(get_phrase(listing.listing_type)) }}
          </small>
        </figure>
        <div
          class="wrapper"
          :class="{ 'featured-body': listing.is_featured == 1 }"
        >
          <h3 class="ellipsis">
            <a :href="getListingUrl(listing.id)">
              {{ listing.name }}
            </a>
            <span
              v-if="isClaimed(listing.id)"
              class="claimed_icon"
              data-toggle="tooltip"
              title="{{ get_phrase('this_listing_is_verified') }}"
            >
              <img src="assets/frontend/images/verified.png" width="23" />
            </span>
          </h3>
          <small>
            {{ getCityStateCountry(listing.city_id, listing.state_id, listing.country_id) }}
          </small>
          <p class="ellipsis">
            {{ listing.description }}
          </p>
          <a
            v-if="listing.latitude !== '' && listing.longitude !== ''"
            class="address"
            href="javascript:"
            :button-direction-id="listing.code"
            target=""
          >
            {{ get_phrase.show_on_map }}
          </a>
        </div>
        <ul :class="{ 'featured-footer': listing.is_featured == 1 }" class="mb-0">
          <li>
            <span
              :class="{
                'loc_closed': isClosedNow(listing.id),
                'loc_open': isOpenNow(listing.id),
              }"
            >
              {{ get_phrase(getOpeningStatus(listing.id)) }}
            </span>
          </li>
          <li>
            <div class="score">
              <span>
                {{ getRatingQuality(listing.id) }}
                <em>
                  {{ get_phrase('reviews', getListingWiseReviewCount(listing.id)) }}
                </em>
              </span>
              <strong>{{ getListingWiseRating(listing.id) }}</strong>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
        </div>
    </div>
  </template>
  
  <script setup>
import { ref, onMounted, onUnmounted } from "vue";
import axios from 'axios';
const title = ref('');
const listings = ref([]);
const get_phrase = ref([]);
const body = document.getElementsByTagName("body")[0];
const getListingUrl = (listingId) => {
  // Assuming you have a method to generate the listing URL
  return `/api/get_listing_url/${listingId}`;
};
const capitalizeFirst = (str) => {
  return str.charAt(0).toUpperCase() + str.slice(1);
};
onMounted(async () => {
  try {

    const response = await axios.get('http://localhost/home/filter_listings');
    console.log('Response from listings:', response.data);
    title.value = response.data.title;
    listings.value = response.data.listings;
    const get_phrases = await axios.get('http://localhost/api/get_phrase');
    console.log('Response from listings:', response.data);
    get_phrase.value = get_phrases.data;
  } catch (error) {
    console.error('Error fetching listing:', error);
  }

  body.classList.add("annonces");
  body.classList.add("bg-gray-200");
});
const isWishlisted = (listingId) => {
  // Assuming you have a method to check if the listing is wishlisted
  // Replace this with your actual logic
  return false;
};

const addToWishList = (listingId) => {
  // Assuming you have a method to add to the wishlist
  // Replace this with your actual logic
  console.log('Add to wishlist:', listingId);
};

const isClaimed = (listingId) => {
  // Assuming you have a method to check if the listing is claimed
  // Replace this with your actual logic
  return false;
};

const getCityStateCountry = (cityId, stateId, countryId) => {
  // Assuming you have a method to get the city, state, and country names
  // Replace this with your actual logic
  return 'City, State, Country';
};

const isOpenNow = (listingId) => {
  // Assuming you have a method to check if the listing is open now
  // Replace this with your actual logic
  return true;
};

const isClosedNow = (listingId) => {
  // Assuming you have a method to check if the listing is closed now
  // Replace this with your actual logic
  return false;
};

const getOpeningStatus = (listingId) => {
  // Assuming you have a method to get the opening status
  // Replace this with your actual logic
  return 'open';
};

const getRatingQuality = (listingId) => {
  // Assuming you have a method to get the quality rating
  // Replace this with your actual logic
  return '5.0'; // Sample rating
};

const getListingWiseReviewCount = (listingId) => {
  // Assuming you have a method to get the review count for the listing
  // Replace this with your actual logic
  return 10; // Sample count
};

const getListingWiseRating = (listingId) => {
  // Assuming you have a method to get the rating for the listing
  // Replace this with your actual logic
  return '4.5'; // Sample rating
};

  </script>
  