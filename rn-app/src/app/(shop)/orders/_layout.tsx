import { View, Text } from "react-native";
import { Stack, Tabs } from "expo-router";

const OrdersLayout = () => {
  return (
    <Stack>
      <Stack.Screen
        name="index"
        options={{ title: "Orders", headerShown: false }}
      />
    </Stack>
  );
};

export default OrdersLayout;
