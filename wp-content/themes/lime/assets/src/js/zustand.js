import { persist } from "zustand/middleware"; // Import the persist middleware
import create from "zustand/vanilla"; // Import the vanilla (non-React) Zustand create function

// Array to store all created Zustand stores
const stores = [];

// Zustand utility object
const zustand = {
  persist, // Expose the persist middleware
  create, // Expose the create function
  stores, // Expose the stores array
};

// Attach the Zustand utility object to the global window object
window.zustand = zustand;
