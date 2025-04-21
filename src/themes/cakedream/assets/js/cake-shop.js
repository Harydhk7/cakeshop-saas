/**
 * Cake Dream Theme - Custom JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
  // Add cake decoration elements to section titles
  const sectionTitles = document.querySelectorAll('.featured-products h2, .new-products h2, .popular-products h2, .product-accessories h2');
  sectionTitles.forEach(title => {
    title.classList.add('cake-decoration');
  });

  // Create a cake shop banner for the homepage
  if (document.body.classList.contains('page-index')) {
    createCakeBanner();
  }

  // Add hover effects to product cards
  enhanceProductCards();

  // Add custom category descriptions for cake categories
  addCakeCategoryDescriptions();
});

/**
 * Creates a promotional banner for the homepage
 */
function createCakeBanner() {
  const homepageContainer = document.querySelector('#content-wrapper .container');
  if (!homepageContainer) return;

  const featuredProducts = document.querySelector('.featured-products');
  if (!featuredProducts) return;

  const banner = document.createElement('div');
  banner.className = 'cake-banner';
  banner.innerHTML = `
    <h3>Delicious Custom Cakes</h3>
    <p>Order a custom cake for your special occasion. We create beautiful and delicious cakes for birthdays, weddings, and celebrations.</p>
    <a href="category?id_category=3" class="btn">Order Now</a>
  `;

  homepageContainer.insertBefore(banner, featuredProducts);
}

/**
 * Enhances product cards with additional hover effects
 */
function enhanceProductCards() {
  const productCards = document.querySelectorAll('.product-miniature');
  
  productCards.forEach(card => {
    // Add hover class for additional styling
    card.addEventListener('mouseenter', function() {
      this.classList.add('product-hover');
    });
    
    card.addEventListener('mouseleave', function() {
      this.classList.remove('product-hover');
    });
    
    // Add quick view button if it doesn't exist
    const productActions = card.querySelector('.product-actions');
    if (productActions && !card.querySelector('.quick-view')) {
      const quickViewBtn = document.createElement('a');
      quickViewBtn.className = 'quick-view';
      quickViewBtn.href = '#';
      quickViewBtn.setAttribute('data-link-action', 'quickview');
      quickViewBtn.innerHTML = '<i class="material-icons">visibility</i> Quick view';
      
      productActions.appendChild(quickViewBtn);
    }
  });
}

/**
 * Adds custom descriptions to cake categories
 */
function addCakeCategoryDescriptions() {
  // Only run on category pages
  if (!document.body.classList.contains('page-category')) return;
  
  const categoryHeader = document.querySelector('#js-product-list-header');
  if (!categoryHeader) return;
  
  // Get category ID from URL
  const urlParams = new URLSearchParams(window.location.search);
  const categoryId = urlParams.get('id_category');
  
  if (!categoryId) return;
  
  // Custom descriptions for cake categories
  const categoryDescriptions = {
    '3': `<div class="category-description cake-category">
            <h2>Birthday Cakes</h2>
            <p>Celebrate your special day with our delicious birthday cakes! Each cake is handcrafted with premium ingredients and can be customized with your favorite flavors and decorations.</p>
            <p>Available in various sizes to serve any party, from intimate gatherings to large celebrations.</p>
          </div>`,
    '4': `<div class="category-description cake-category">
            <h2>Wedding Cakes</h2>
            <p>Make your wedding day even more memorable with our elegant wedding cakes. Our expert bakers create stunning multi-tiered cakes that taste as amazing as they look.</p>
            <p>Schedule a tasting consultation to design your perfect wedding cake.</p>
          </div>`,
    '5': `<div class="category-description cake-category">
            <h2>Cupcakes</h2>
            <p>Our gourmet cupcakes are perfect for any occasion! Available in a variety of flavors and decorations, these bite-sized treats are sure to delight everyone.</p>
            <p>Order by the dozen for parties, events, or just because!</p>
          </div>`,
    '6': `<div class="category-description cake-category">
            <h2>Pastries</h2>
            <p>Indulge in our selection of freshly baked pastries. From flaky croissants to delicate Danish pastries, our pastry selection offers something for every taste.</p>
            <p>Perfect for breakfast, brunch, or an afternoon treat!</p>
          </div>`
  };
  
  // Add the custom description if available
  if (categoryDescriptions[categoryId]) {
    categoryHeader.innerHTML += categoryDescriptions[categoryId];
  }
}
