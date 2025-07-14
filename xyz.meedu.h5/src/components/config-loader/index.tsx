import { useEffect, useState } from "react";
import { useDispatch } from "react-redux";
import { system } from "../../api";
import { saveConfigAction } from "../../store/system/systemConfigSlice";
import { AppConfigInterface } from "../../store/system/systemConfigSlice";

interface ConfigLoaderProps {
  children: React.ReactNode;
  onConfigLoaded?: (config: AppConfigInterface) => void;
}

export const ConfigLoader = ({ children, onConfigLoaded }: ConfigLoaderProps) => {
  const dispatch = useDispatch();
  const [configLoaded, setConfigLoaded] = useState(false);
  const [configData, setConfigData] = useState<AppConfigInterface | null>(null);

  useEffect(() => {
    const loadConfig = async () => {
      try {
        const configRes: any = await system.config();
        const config = configRes.data;
        
        // 保存配置到 store
        dispatch(saveConfigAction(config));
        setConfigData(config);
        
        // 如果传入了回调函数，则调用它
        if (onConfigLoaded) {
          onConfigLoaded(config);
        }
        
        setConfigLoaded(true);
      } catch (error) {
        console.error("配置加载失败", error);
        // 即使配置加载失败，也允许应用继续运行
        setConfigLoaded(true);
      }
    };

    loadConfig();
  }, [dispatch, onConfigLoaded]);

  // 只有在配置加载完成后才渲染子组件
  if (!configLoaded) {
    return (
      <div style={{ 
        display: 'flex', 
        justifyContent: 'center', 
        alignItems: 'center', 
        height: '100vh' 
      }}>
        <div>加载中...</div>
      </div>
    );
  }

  return <>{children}</>;
};

export default ConfigLoader; 