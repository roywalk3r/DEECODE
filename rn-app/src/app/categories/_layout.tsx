import { Stack } from "expo-router";
import { TouchableOpacity } from "react-native";
import { Ionicons } from "@expo/vector-icons";
const CategoriesLayout = () => {
  return (
    <Stack>
      <Stack.Screen
        name="[slug]"
        options={({ navigation }) => ({
          headerShown: true,
          title: "Categories",
          headerStyle: { backgroundColor: "#f5f5f5" },
          headerTitleStyle: { fontWeight: "bold" },
          headerRight: () => (
            <TouchableOpacity
              onPress={() => navigation.navigate("search")}
              style={{ marginRight: 10 }}
            >
              <Ionicons name="search" size={24} color="black" />
            </TouchableOpacity>
          ),
          headerLeft: () => (
            <TouchableOpacity onPress={() => navigation.goBack()}>
              <Ionicons name="arrow-back" size={24} color="black" />
            </TouchableOpacity>
          ),
        })}
      />
    </Stack>
  );
};

export default CategoriesLayout;
