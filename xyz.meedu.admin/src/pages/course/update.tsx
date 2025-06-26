import { useState, useEffect } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import {
  Button,
  Input,
  message,
  Form,
  DatePicker,
  Switch,
  Space,
  Select,
  Row,
  Col,
  Spin,
} from "antd";
import { useDispatch } from "react-redux";
import { course } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import {
  BackBartment,
  PerButton,
  UploadImageButton,
  HelperText,
  QuillEditor,
} from "../../components";
import dayjs from "dayjs";
import moment from "moment";

const CourseUpdatePage = () => {
  const result = new URLSearchParams(useLocation().search);
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [init, setInit] = useState(true);
  const [loading, setLoading] = useState(false);
  const [categories, setCategories] = useState<CategoryOption[]>([]);
  const [isFree, setIsFree] = useState(0);
  const [, setIsVipFree] = useState(0);
  const [thumb, setThumb] = useState("");
  const [defautValue, setDefautValue] = useState("");
  const [id, setId] = useState(Number(result.get("id")));

  useEffect(() => {
    document.title = "编辑录播课程";
    dispatch(titleAction("编辑录播课程"));
    initData();
  }, [id]);

  useEffect(() => {
    setId(Number(result.get("id")));
  }, [result.get("id")]);

  const initData = async () => {
    await getParams();
    await getDetail();
    setInit(false);
  };

  const getDetail = async () => {
    if (id === 0) {
      return;
    }
    const res: CourseDetailResponse = await course.detail(id);
    const data = res.data;
    form.setFieldsValue({
      category_id: data.category_id,
      title: data.title,
      thumb: data.thumb,
      is_show: data.is_show,
      is_free: data.is_free,
      is_vip_free: data.is_vip_free,
      short_description: data.short_description,
      original_desc: data.original_desc,
      charge: data.charge,
      published_at: dayjs(data.published_at, "YYYY-MM-DD HH:mm"),
      is_allow_comment: data.is_allow_comment,
    });
    setIsFree(data.is_free);
    setIsVipFree(data.is_vip_free);
    setDefautValue(data.original_desc);
    setThumb(data.thumb);
  };

  const getParams = async () => {
    try {
      const res: CourseCreateResponse = await course.create();
      const { categories: categoryData } = res.data;

      const formattedCategories: CategoryOption[] = categoryData.flatMap(
        (category) => {
          // Add parent category
          const result: CategoryOption[] = [
            {
              label: category.name,
              value: category.id,
            },
          ];

          // Add children categories with proper indentation if they exist
          if (category.children && category.children.length > 0) {
            const formattedChildren = category.children.map((child) => ({
              label: `|----${child.name}`,
              value: child.id,
            }));
            result.push(...formattedChildren);
          }

          return result;
        }
      );

      setCategories(formattedCategories);
    } catch (error) {
      console.error("Failed to fetch categories:", error);
    }
  };

  const onFinish = (values: CourseFormData) => {
    console.log(values);
    if (loading) {
      return;
    }
    if (values.is_free === 1) {
      values.charge = 0;
    }
    if (Number(values.charge) % 1 !== 0) {
      message.error("课程价格必须为整数型");
      return;
    }
    if (values.is_free === 0 && Number(values.charge) <= 0) {
      message.error("课程未设置免费时价格应该大于0");
      return;
    }
    values.render_desc = values.original_desc;
    values.published_at = moment(new Date(values.published_at)).format(
      "YYYY-MM-DD HH:mm"
    );
    setLoading(true);
    course
      .update(id, values)
      .then(() => {
        setLoading(false);
        message.success("保存成功！");
        navigate(-1);
      })
      .catch(() => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const onSwitch = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ is_show: 1 });
    } else {
      form.setFieldsValue({ is_show: 0 });
    }
  };

  const isVChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ is_free: 1, is_vip_free: 0 });
      setIsFree(1);
      setIsVipFree(0);
    } else {
      form.setFieldsValue({ is_free: 0 });
      setIsFree(0);
    }
  };

  const isAllowCommentChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ is_allow_comment: 1 });
    } else {
      form.setFieldsValue({ is_allow_comment: 0 });
    }
  };

  const isVipFreeChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ is_vip_free: 1 });
      setIsVipFree(1);
    } else {
      form.setFieldsValue({ is_vip_free: 0 });
      setIsVipFree(0);
    }
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="编辑录播课程" />
      {init && (
        <div className="float-left text-center mt-30">
          <Spin />
        </div>
      )}
      <div
        style={{ display: init ? "none" : "block" }}
        className="float-left mt-30"
      >
        <Form
          form={form}
          name="course-update"
          labelCol={{ span: 3 }}
          wrapperCol={{ span: 21 }}
          initialValues={{ remember: true }}
          onFinish={onFinish}
          onFinishFailed={onFinishFailed}
          autoComplete="off"
        >
          <Form.Item
            name="category_id"
            label="所属分类"
            rules={[{ required: true, message: "请选择所属分类!" }]}
          >
            <Space align="baseline" style={{ height: 32 }}>
              <Form.Item
                name="category_id"
                rules={[{ required: true, message: "请选择所属分类!" }]}
              >
                <Select
                  style={{ width: 300 }}
                  allowClear
                  placeholder="请选择所属分类"
                  options={categories}
                />
              </Form.Item>
              <div>
                <PerButton
                  type="link"
                  text="分类管理"
                  class="c-primary"
                  icon={null}
                  p="courseCategory"
                  onClick={() => {
                    navigate("/course/vod/category/index");
                  }}
                  disabled={null}
                />
              </div>
            </Space>
          </Form.Item>
          <Form.Item
            label="课程名称"
            name="title"
            rules={[{ required: true, message: "请输入课程名称!" }]}
          >
            <Input
              style={{ width: 300 }}
              placeholder="请输入课程名称"
              allowClear
            />
          </Form.Item>
          <Form.Item
            label="课程封面"
            name="thumb"
            rules={[{ required: true, message: "请上传课程封面!" }]}
          >
            <Space align="baseline" style={{ height: 32 }}>
              <Form.Item
                name="thumb"
                rules={[{ required: true, message: "请上传课程封面!" }]}
              >
                <UploadImageButton
                  text="选择图片"
                  scene="cover"
                  onSelected={(url) => {
                    form.setFieldsValue({ thumb: url });
                    setThumb(url);
                  }}
                />
              </Form.Item>
              <div className="ml-10">
                <HelperText text="长宽比4:3，建议尺寸：400x300像素" />
              </div>
            </Space>
          </Form.Item>
          {thumb && (
            <Row style={{ marginBottom: 22 }}>
              <Col span={3}></Col>
              <Col span={21}>
                <div
                  className="contain-thumb-box"
                  style={{
                    backgroundImage: `url(${thumb})`,
                    width: 200,
                    height: 150,
                  }}
                ></div>
              </Col>
            </Row>
          )}
          <Form.Item label="免费" name="is_free" valuePropName="checked">
            <Switch onChange={isVChange} />
          </Form.Item>
          {isFree === 0 && (
            <Form.Item
              label="VIP免费"
              name="is_vip_free"
              valuePropName="checked"
            >
              <Switch onChange={isVipFreeChange} />
            </Form.Item>
          )}
          {isFree === 0 && (
            <Form.Item
              label="价格"
              name="charge"
              rules={[{ required: true, message: "请输入价格!" }]}
            >
              <Space align="baseline" style={{ height: 32 }}>
                <Form.Item
                  name="charge"
                  rules={[{ required: true, message: "请输入价格!" }]}
                >
                  <Input
                    style={{ width: 300 }}
                    placeholder="单位：元"
                    allowClear
                    type="number"
                  />
                </Form.Item>
                <div className="ml-10">
                  <HelperText text="最小单位：元，不支持小数" />
                </div>
              </Space>
            </Form.Item>
          )}
          <Form.Item label="上架时间" required={true}>
            <Space align="baseline" style={{ height: 32 }}>
              <Form.Item
                name="published_at"
                rules={[{ required: true, message: "请选择上架时间!" }]}
              >
                <DatePicker
                  format="YYYY-MM-DD HH:mm"
                  style={{ width: 300 }}
                  showTime
                  placeholder="请选择上架时间"
                />
              </Form.Item>
              <div className="ml-10">
                <HelperText text="上架时间越晚，排序越靠前" />
              </div>
            </Space>
          </Form.Item>
          <Form.Item label="显示" name="is_show">
            <Space align="baseline" style={{ height: 32 }}>
              <Form.Item name="is_show" valuePropName="checked">
                <Switch onChange={onSwitch} />
              </Form.Item>
              <div className="ml-10">
                <HelperText text="关闭后此课程在前台隐藏显示" />
              </div>
            </Space>
          </Form.Item>
          <Form.Item
            label="允许评论"
            name="is_allow_comment"
            valuePropName="checked"
          >
            <Switch onChange={isAllowCommentChange} />
          </Form.Item>
          <Form.Item
            label="简短介绍"
            name="short_description"
            rules={[{ required: true, message: "请输入简短介绍!" }]}
          >
            <Input.TextArea
              style={{ width: 800 }}
              placeholder="请填写课程简单介绍"
              allowClear
              rows={4}
              maxLength={150}
              showCount
            />
          </Form.Item>
          <Form.Item
            label="详情介绍"
            name="original_desc"
            rules={[{ required: true, message: "请输入详情介绍!" }]}
            style={{ height: 840 }}
          >
            <div className="w-800px">
              <QuillEditor
                mode=""
                height={800}
                defautValue={defautValue}
                isFormula={false}
                setContent={(value: string) => {
                  form.setFieldsValue({ original_desc: value });
                }}
              ></QuillEditor>
            </div>
          </Form.Item>
        </Form>
      </div>
      <div className="bottom-menus">
        <div className="bottom-menus-box">
          <div>
            <Button
              loading={loading}
              type="primary"
              onClick={() => form.submit()}
            >
              保存
            </Button>
          </div>
          <div className="ml-24">
            <Button type="default" onClick={() => navigate(-1)}>
              取消
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CourseUpdatePage;
