import "react-native-gesture-handler";
import { Stack } from "expo-router";
import { ToastProvider } from "react-native-toast-notifications";
import AuthProvider from "./providers/auth-provider";
export default function RootLayout() {
  return (
    <AuthProvider>
      <ToastProvider>
        <Stack>
          <Stack.Screen
            name="(shop)"
            options={{ headerShown: false, title: "Shop" }}
          />
          <Stack.Screen
            name="categories"
            options={{
              headerShown: false,
              title: "Categories",
              headerTitleAlign: "center",
            }}
          />
          <Stack.Screen
            name="product"
            options={{ headerShown: false, title: "Products" }}
          />
          <Stack.Screen
            name="cart"
            options={{
              title: "Shopping Cart",
              gestureEnabled: true,
              presentation: "transparentModal",
            }}
          />
          <Stack.Screen name="auth" options={{ headerShown: true }} />
        </Stack>
      </ToastProvider>
    </AuthProvider>
  );
}
