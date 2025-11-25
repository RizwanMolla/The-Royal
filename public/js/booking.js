// Dynamic price calculation for booking form
document.addEventListener("DOMContentLoaded", function () {
  const checkInInput = document.getElementById("check_in");
  const checkOutInput = document.getElementById("check_out");
  const pricePerNightInput = document.getElementById("price_per_night");
  const totalPriceDisplay = document.getElementById("total_price");
  const totalPriceHidden = document.getElementById("total_price_hidden");

  if (checkInInput && checkOutInput && pricePerNightInput) {
    const pricePerNight = parseFloat(pricePerNightInput.value);

    function calculateTotal() {
      const checkIn = checkInInput.value;
      const checkOut = checkOutInput.value;

      if (checkIn && checkOut) {
        const startDate = new Date(checkIn);
        const endDate = new Date(checkOut);

        // Calculate number of nights
        const timeDiff = endDate - startDate;
        const nights = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

        if (nights > 0) {
          const total = nights * pricePerNight;
          totalPriceDisplay.textContent = "$" + total.toFixed(2);
          if (totalPriceHidden) {
            totalPriceHidden.value = total.toFixed(2);
          }
        } else {
          totalPriceDisplay.textContent = "$0.00";
          if (totalPriceHidden) {
            totalPriceHidden.value = "0";
          }
        }
      }
    }

    // Set minimum dates
    const today = new Date().toISOString().split("T")[0];
    checkInInput.setAttribute("min", today);

    checkInInput.addEventListener("change", function () {
      const checkInDate = new Date(this.value);
      const nextDay = new Date(checkInDate);
      nextDay.setDate(nextDay.getDate() + 1);
      checkOutInput.setAttribute("min", nextDay.toISOString().split("T")[0]);
      calculateTotal();
    });

    checkOutInput.addEventListener("change", calculateTotal);
  }
});
