// Function to regenerate product code via AJAX
async function regenerateProductCode() {
    const productCodeInput = document.getElementById("product_code");
    const regenerateBtn = document.querySelector(
        '[onclick="regenerateProductCode()"]'
    );

    // Show loading state
    const originalText = regenerateBtn.innerHTML;
    regenerateBtn.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <span class="ml-1 hidden sm:inline">Generating...</span>
    `;
    regenerateBtn.disabled = true;

    try {
        // Make AJAX request to generate new product code
        const response = await fetch(
            '{{ route("inventory.products.generate-code") }}',
            {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            }
        );

        if (response.ok) {
            const data = await response.json();
            productCodeInput.value = data.product_code;

            // Show success feedback
            showToast("New product code generated successfully!", "success");
        } else {
            throw new Error("Failed to generate product code");
        }
    } catch (error) {
        console.error("Error:", error);
        showToast(
            "Failed to generate product code. Please try again.",
            "error"
        );
    } finally {
        // Restore button state
        regenerateBtn.innerHTML = originalText;
        regenerateBtn.disabled = false;
    }
}

// Toast notification function
function showToast(message, type = "info") {
    const toast = document.createElement("div");
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium animate-slide-in-right ${
        type === "success"
            ? "bg-green-500"
            : type === "error"
            ? "bg-red-500"
            : "bg-blue-500"
    }`;
    toast.innerHTML = `
        <div class="flex items-center">
            ${
                type === "success"
                    ? '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
                    : type === "error"
                    ? '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'
                    : '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            }
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(toast);

    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.classList.add("opacity-0", "transition-opacity", "duration-300");
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animation for toast
const style = document.createElement("style");
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .animate-slide-in-right {
        animation: slideInRight 0.3s ease-out;
    }
`;
document.head.appendChild(style);
